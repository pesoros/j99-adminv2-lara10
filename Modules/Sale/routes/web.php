<?php

use Illuminate\Support\Facades\Route;
use Modules\Sale\app\Http\Controllers\SaleCustomerController;

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
    Route::prefix('sale')->group(function () {
        Route::get('customer', [SaleCustomerController::class, 'listCustomer']);
        Route::get('customer/add', [SaleCustomerController::class, 'addCustomer']);
        Route::post('customer/add', [SaleCustomerController::class, 'addCustomerStore']);
        Route::get('customer/edit/{uuid}', [SaleCustomerController::class, 'editCustomer']);
        Route::post('customer/edit/{uuid}', [SaleCustomerController::class, 'editCustomerUpdate']);
        Route::get('customer/delete/{uuid}', [SaleCustomerController::class, 'deleteCustomer']);
    });
});