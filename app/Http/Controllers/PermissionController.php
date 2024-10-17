<?php

namespace App\Http\Controllers;

use App\Http\Resources\PermissionResource;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        return PermissionResource::collection(Permission::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions',
        ]);

        $permission = Permission::create($request->all());

        return new PermissionResource($permission);
    }

    public function show(Permission $permission)
    {
        return new PermissionResource($permission);
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update($request->all());

        return new PermissionResource($permission);
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        return response()->json(['message' => 'Permission deleted successfully']);
    }
}
