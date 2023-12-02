<?php

use Illuminate\Support\Facades\Route;
use Modules\UserManagement\app\Http\Controllers\UserManagementController;

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

Route::group([], function () {
    Route::get('usermanagement/account', [UserManagementController::class, 'index']);
    Route::get('usermanagement/account/add', [UserManagementController::class, 'addAccount']);
});
