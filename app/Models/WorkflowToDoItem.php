<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class WorkflowToDoItem extends WorkflowItem
{
    use HasFactory;

    protected $fillable = ['user_id', 'workflow_id', 'name', 'checklist', 'days', 'role', 'order'];
    public $type = "todo";
    protected $casts = [
        'checklist' => 'array'
    ];

    public function assigned() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getChecklistAttribute($value) {
        if (json_decode($value)) {
            return json_decode($value);
        } else {

            $steps = [];

            $items = (is_array($value)) ? $value : explode("\r\n", $value);

            foreach ($items as $item) {
                $obj = [];
                $obj["task"] = $item;
                $obj["status"] = 0;
                array_push($steps, $obj);
            };

            return $steps;
        }
    }


}
