<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    // Create the user
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    // Assign the 'admin' role to the user
    $role = Role::findByName('admin');
    $user->assignRole($role);

    // Generate API token for the user
    $token = $user->createToken('auth_token')->plainTextToken;

    // Get the user's roles and permissions
    $roles = $user->getRoleNames();
    $permissions = $user->getAllPermissions()->pluck('name');

    return response()->json([
        'message' => 'User registered successfully',
        'token' => $token,
        'roles' => $roles,
        'permissions' => $permissions,
    ]);
}


public function login(Request $request)
{
    $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }
    $token = $user->createToken('auth_token')->plainTextToken;
    // get role and permision for this user
    $roles = $user->getRoleNames();
    $permissions = $user->getAllPermissions()->pluck('name');

    return response()->json([
        'token' => $token,
        'roles' => $roles,
        'permissions' => $permissions,
    ]);
}


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
