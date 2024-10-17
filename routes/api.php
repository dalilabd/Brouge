<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
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
// Role Routess
Route::apiResource('roles', RoleController::class);
// Permission Routees
Route::apiResource('permissions', PermissionController::class);
// Admin Routes (for user management)
Route::apiResource('admins', AdminController::class);
// user Routes (for read uses all)
Route::resource('users', UserController::class);

use App\Http\Controllers\CategoryController;
Route::resource('categories', CategoryController::class);
use App\Http\Controllers\DocumentController;
Route::resource('documents', DocumentController::class);
