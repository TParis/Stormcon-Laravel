<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApiTokensToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->string('api_token', 80)->after('password')
                ->nullable()
                ->default(null);
        });
        User::all()->each(function(User $user) {
            $user->api_token = hash("sha256", Str::random(60));
            $user->save();
        });
        Schema::table('users', function ($table) {
            $table->unique('api_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('users_api_token_unique');
            $table->dropColumn("api_token");
        });
    }
}
