<?php

use Illuminate\Support\Facades\Route;
use Modules\Masterdata\app\Http\Controllers\MasterdataController;

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

Route::middleware(['auth','has-permission'])->group(function () {
    Route::prefix('masterdata')->group(function () {
        Route::get('bus', [MasterdataController::class, 'listMasterBus']);
        Route::get('bus/add', [MasterdataController::class, 'addMasterBus']);
        Route::post('bus/add', [MasterdataController::class, 'addMasterBusStore']);
    });
});