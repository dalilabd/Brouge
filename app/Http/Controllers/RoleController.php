<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        return RoleResource::collection(Role::all());
    }

    // ajouter r
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles',
        ]);

        $role = Role::create($request->all());

        return new RoleResource($role);
    }

    public function show(Role $role)
    {
        return new RoleResource($role);
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
        ]);

        $role->update($request->all());

        return new RoleResource($role);
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return response()->json(['message' => 'Role deleted successfully']);
    }
}
