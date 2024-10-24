<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DocumentController;

/*
|-----------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {

    return $request->user();
});
// authentificaation
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {
    // Role Routes
    Route::apiResource('roles', RoleController::class);
    // Permission Routes
    Route::apiResource('permissions', PermissionController::class);
    // Admin Routes (for user management)
    Route::apiResource('admins', AdminController::class);
    // User Routes (for reading user data, CRUD operations)
    Route::apiResource('users', UserController::class);
    // Category Routes
    Route::apiResource('categories', CategoryController::class);
    // Document Routes
    Route::apiResource('documents', DocumentController::class);
});
// Role Routess
// Route::apiResource('roles', RoleController::class);
// // Permission Routees
// Route::apiResource('permissions', PermissionController::class);
// // Admin Routes (for user management)
// Route::apiResource('admins', AdminController::class);
// // user Routes (for read uses all)
// Route::resource('users', UserController::class);

// Route::resource('categories', CategoryController::class);
// Route::resource('documents', DocumentController::class);
