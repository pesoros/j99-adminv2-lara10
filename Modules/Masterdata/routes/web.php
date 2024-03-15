<?php

use Illuminate\Support\Facades\Route;
use Modules\Masterdata\app\Http\Controllers\MasterdataBusController;
use Modules\Masterdata\app\Http\Controllers\MasterdataClassController;
use Modules\Masterdata\app\Http\Controllers\MasterdataFacilitiesController;
use Modules\Masterdata\app\Http\Controllers\MasterdataCityController;

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
        //Bus
        Route::get('bus', [MasterdataBusController::class, 'listMasterBus']);
        Route::get('bus/add', [MasterdataBusController::class, 'addMasterBus']);
        Route::post('bus/add', [MasterdataBusController::class, 'addMasterBusStore']);
        Route::get('bus/edit/{uuid}', [MasterdataBusController::class, 'editMasterBus']);
        Route::post('bus/edit/{uuid}', [MasterdataBusController::class, 'editMasterBusUpdate']);
        Route::get('bus/delete/{uuid}', [MasterdataBusController::class, 'deleteMasterBus']);
        //Class
        Route::get('class', [MasterdataClassController::class, 'listMasterClass']);
        Route::get('class/add', [MasterdataClassController::class, 'addMasterClass']);
        Route::post('class/add', [MasterdataClassController::class, 'addMasterClassStore']);
        Route::get('class/edit/{uuid}', [MasterdataClassController::class, 'editMasterClass']);
        Route::post('class/edit/{uuid}', [MasterdataClassController::class, 'editMasterClassUpdate']);
        Route::get('class/delete/{uuid}', [MasterdataClassController::class, 'deleteMasterClass']);
        //Facilities
        Route::get('facilities', [MasterdataFacilitiesController::class, 'listMasterFacilities']);
        Route::get('facilities/add', [MasterdataFacilitiesController::class, 'addMasterFacilities']);
        Route::post('facilities/add', [MasterdataFacilitiesController::class, 'addMasterFacilitiesStore']);
        Route::get('facilities/edit/{uuid}', [MasterdataFacilitiesController::class, 'editMasterFacilities']);
        Route::post('facilities/edit/{uuid}', [MasterdataFacilitiesController::class, 'editMasterFacilitiesUpdate']);
        Route::get('facilities/delete/{uuid}', [MasterdataFacilitiesController::class, 'deleteMasterFacilities']);
        //City
        Route::get('city', [MasterdataCityController::class, 'listMasterCity']);
        Route::get('city/add', [MasterdataCityController::class, 'addMasterCity']);
        Route::post('city/add', [MasterdataCityController::class, 'addMasterCityStore']);
        Route::get('city/edit/{uuid}', [MasterdataCityController::class, 'editMasterCity']);
        Route::post('city/edit/{uuid}', [MasterdataCityController::class, 'editMasterCityUpdate']);
        Route::get('city/delete/{uuid}', [MasterdataCityController::class, 'deleteMasterCity']);
    });
});