<?php

use Illuminate\Support\Facades\Route;
use Modules\UserManagement\app\Http\Controllers\AccountController;
use Modules\UserManagement\app\Http\Controllers\RoleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth'])->group(function () {
    Route::get('usermanagement/account', [AccountController::class, 'listAccount']);
    Route::get('usermanagement/account/add', [AccountController::class, 'addAccount']);
    Route::post('usermanagement/account/add', [AccountController::class, 'addAccountStore']);
    Route::get('usermanagement/role', [RoleController::class, 'listRole']);
    Route::get('usermanagement/role/add', [RoleController::class, 'addRole']);
    Route::post('usermanagement/role/add', [RoleController::class, 'addRoleStore']);
    Route::get('usermanagement/role/permission/{role_uuid}', [RoleController::class, 'permissionForm']);
});
