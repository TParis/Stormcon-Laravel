<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

class CreateRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Role::create(["name" => "Owner"]);
        Role::create(["name" => "Initiator"]);
        Role::create(["name" => "Maps"]);
        Role::create(["name" => "Inspector"]);
        Role::create(["name" => "Publisher"]);
        Role::create(["name" => "NOIs"]);
        Role::create(["name" => "Research"]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     * @throws Exception
     */
    public function down()
    {
        Role::all()->each(function(Role $role) {
            $role->delete();
        });
    }
}
