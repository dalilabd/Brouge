<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserAdded;


class AdminController extends Controller
{
    public function index()
    {
        // Retrieve all users and return as JSON
        $users = User::role('admin')->get();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'permissions' => 'array', // Add this line for permissions
            'permissions.*' => 'string|exists:permissions,name', // Ensure permissions exist
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Assign role 'admin' to the newly created user
        $user->assignRole('admin');

        // Assign selected permissions to the user
        if ($request->has('permissions')) {
            $user->givePermissionTo($request->permissions);
        }

        // Send email (optional)
        // Mail::to($user->email)->send(new UserAdded($user));

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ]);
    }

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'string|nullable',
            'email' => 'string|email|nullable',
        ]);

        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->update($request->only(['name', 'email']));

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user
        ]);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
