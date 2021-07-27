<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class LoadPermissions extends Migration
{

    private $role_perms = '[
        {
        "Owner": ["viewUsers", "editUsers", "deleteUsers", "listUsers", "viewProjects", "editProjects", "deleteProjects", "listProjects", "viewConfig", "editConfig", "deleteConfig", "listConfig", "viewInspections", "editInspections", "listInspections", "exportSWPPP", "login", "changeOwnPassword", "changePasswords", "viewWorkflows", "editWorkflows", "deleteWorkflows", "listWorkflows", "createProject", "commentProject", "skipWorkflow", "addBlockers", "clearBlockers", "uploadFiles", "viewFiles", "", "", "", "", "", "", ""]
        },
        {
        "Sr Admin": ["viewUsers", "editUsers", "deleteUsers", "listUsers", "viewProjects", "editProjects", "deleteProjects", "listProjects", "viewConfig", "editConfig", "deleteConfig", "listConfig", "viewInspections", "editInspections", "listInspections", "exportSWPPP", "login", "changeOwnPassword", "changePasswords", "viewWorkflows", "editWorkflows", "deleteWorkflows", "listWorkflows", "createProject", "commentProject", "skipWorkflow", "addBlockers", "clearBlockers", "uploadFiles", "viewFiles", "", "", "", "", "", "", ""]
        },
        {
        "Admin": ["viewUsers", "editUsers", "deleteUsers", "listUsers", "viewProjects", "editProjects", "deleteProjects", "listProjects", "viewConfig", "editConfig", "deleteConfig", "listConfig", "viewInspections", "editInspections", "listInspections", "exportSWPPP", "login", "changeOwnPassword", "", "viewWorkflows", "editWorkflows", "deleteWorkflows", "listWorkflows", "createProject", "commentProject", "skipWorkflow", "addBlockers", "clearBlockers", "uploadFiles", "viewFiles", "", "", "", "", "", "", ""]
        },
        {
        "Initiator": ["", "", "", "", "viewProjects", "editProjects", "deleteProjects", "listProjects", "", "", "", "", "", "", "", "", "", "changeOwnPassword", "", "", "", "listWorkflows", "createProject", "commentProject", "", "", "addBlockers", "clearBlockers", "uploadFiles", "viewFiles", "", "", "", "", "", "", ""]
        },
        {
        "Inspector": ["", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "changeOwnPassword", "", "", "", "", "", "commentProject", "", "", "addBlockers", "clearBlockers", "uploadFiles", "viewFiles", "viewOwnInspections", "editOwnInspections", "listOwnInspections", "", "", "", ""]
        },
        {
        "Inspector Supervisor": ["", "", "", "", "", "", "", "", "", "", "", "", "viewInspections", "editInspections", "listInspections", "", "", "changeOwnPassword", "", "", "", "", "", "commentProject", "", "", "addBlockers", "clearBlockers", "uploadFiles", "viewFiles", "", "", "", "", "", "", ""]
        },
        {
        "Maps": ["viewProjects", "editProjects", "deleteProjects", "listProjects","", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "changeOwnPassword", "", "", "", "", "", "commentProject", "", "", "addBlockers", "clearBlockers", "uploadFiles", "viewFiles", "", "", "", "viewOwnProjects", "editOwnProjects", "deleteOwnProjects", "listOwnProjects"]
        },
        {
        "NOIs": ["viewProjects", "editProjects", "deleteProjects", "listProjects","", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "changeOwnPassword", "", "", "", "", "", "commentProject", "", "", "addBlockers", "clearBlockers", "uploadFiles", "viewFiles", "", "", "", "viewOwnProjects", "editOwnProjects", "deleteOwnProjects", "listOwnProjects"]
        },
        {
        "Publisher": ["viewProjects", "editProjects", "deleteProjects", "listProjects","", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "exportSWPPP", "", "changeOwnPassword", "", "", "", "", "", "commentProject", "", "", "addBlockers", "clearBlockers", "uploadFiles", "viewFiles", "", "", "", "", "", "", ""]
        },
        {
        "Research": ["viewProjects", "editProjects", "deleteProjects", "listProjects","", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "changeOwnPassword", "", "", "", "", "", "commentProject", "", "", "addBlockers", "clearBlockers", "uploadFiles", "viewFiles", "", "", "", "viewOwnProjects", "editOwnProjects", "deleteOwnProjects", "listOwnProjects"]
        }
        ]';

    private $roles = [];
    private $perms = [];


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $data = json_decode($this->role_perms);

        foreach ($data as $row) {
            foreach ($row as $role => $perms) {
                if (!in_array($role, $this->roles)) array_push($this->roles, $role);
                foreach ($perms as $perm) {
                    if ($perm == "") continue;
                    if (!in_array($perm, $this->perms)) array_push($this->perms, $perm);
                }
            }
        }

        foreach ($this->perms as $perm) {
            echo "Creating permission: " . $perm . "\n";
            $perm = Permission::updateOrCreate(['name' => $perm, 'guard_name' => 'web']);
            if ($perm->save()) echo "Created " . $perm->name . "\n";
            $perm = Permission::findByName($perm->name);
            print "Verified " . $perm->name . "\n";
        }
        foreach ($this->roles as $role) {
            echo "Creating role: " . $role . "\n";
            $role = Role::updateOrCreate(['name' => $role]);
            if ($role->save()) echo "Created " . $role->name . "\n";
        }

        foreach ($data as $row) {
            foreach ($row as $role => $perms) {
                $role = Role::findByName($role);
                print "Adding perms to " . $role->name . "\n";
                $role->syncPermissions($perms);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
