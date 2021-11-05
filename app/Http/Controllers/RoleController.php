<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function index()
    {
        if (!Auth::user()->hasAnyRole(['Admin', 'Sr Admin', 'Owner'])) return response("Unauthorized", 403);
        $roles = Role::all();
        return response()->view('roles.index', compact('roles'));
    }
    public function show(Role $role)
    {
        if (!Auth::user()->hasAnyRole(['Admin', 'Sr Admin', 'Owner'])) return response("Unauthorized", 403);
        return response()->view('roles.view');
    }
    public function create()
    {
        if (!Auth::user()->hasAnyRole(['Admin', 'Sr Admin', 'Owner'])) return response("Unauthorized", 403);
        return response()->view('roles.add');
    }
    public function store(Request $request)
    {
        $role = new Role($request->all());
        $role->save();
        return $this->index();
    }
    public function edit(Role $role)
    {
        if (!Auth::user()->hasAnyRole(['Admin', 'Sr Admin', 'Owner'])) return response("Unauthorized", 403);
        return response()->view('roles.edit', compact('role'));
    }
    public function update(Request $request, Role $role)
    {
        $role->name = $request->name;
        $role->save();
        return $this->index();
    }
    public function destroy(Role $role)
    {
        if (!Auth::user()->hasAnyRole(['Admin', 'Sr Admin', 'Owner'])) return response("Unauthorized", 403);
        if (in_array($role->name, ['Admin', 'Sr Admin', 'Owner', 'Inspector', 'Inspector Supervisor'])) return response("Cannot delete core roles", 403);
        $role->delete();
        return $this->index();
    }
}
