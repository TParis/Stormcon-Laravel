<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Spatie\Permission\Traits\HasRoles;
use Krizalys\Onedrive\Onedrive;
use Microsoft\Graph\Graph;
use League\Flysystem\Filesystem;
use NicolasBeauvais\FlysystemOneDrive\OneDriveAdapter;

use App\Http\Controllers\ProjectController;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'fullName',
        'phone',
        'active',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'api_token',
        'onedrive_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function routeNotificationForMail($notification)
    {
        // Return email address and name...
        return [$this->email => $this->fullName];
    }

    public function projects() {
        return $this->hasMany(WorkflowToDoItem::class);
    }

    public function inspections() {
        return $this->hasMany(Inspection::class, 'inspector_id');
    }

    public function getProjectsAssignedAttribute() {
        $projects = $this->projects()->whereHas('project', function(Builder $query) {
            $query->where('status', '!=', ProjectController::STATUS_CLOSE);
        });
        return $projects->count();
    }

    public function getOneDrive($personal = False) {
        if (!$this->onedrive_token) return null;

        $state = new \stdClass();
        $state->token = unserialize($this->onedrive_token);

        $client = Onedrive::client(
            config('onedrive.client_id'),
            [
                // Restore the previous state while instantiating this client to proceed
                // in obtaining an access token.
                'state' => $state,
            ]
        );

        // Obtain the token using the code received by the OneDrive API.
        $client->renewAccessToken(config('onedrive.client_secret'));

        $graph = new Graph();
        $graph->setAccessToken($state->token->data->access_token);

        $adapter = new OneDriveAdapter($graph, config("onedrive.shared_drive"));
        if ($personal) $adapter = new OneDriveAdapter($graph, config("onedrive.personal_drive"));
        $filesystem = new Filesystem($adapter);

        return $filesystem;
    }

    /**
     * @return bool
     */
    public function need_token(): bool
    {
        if (!isset($this->onedrive_token)) return true;

        $token_obj = unserialize($this->onedrive_token);
        $expires = Carbon::createFromTimestamp($token_obj->obtained + $token_obj->data->expires_in);
        if (Carbon::now()->gte($expires)) return true;

        return false;

    }


    public function inspecting() {
        return $this->hasMany(Project::class, 'inspector_id');
    }

}
