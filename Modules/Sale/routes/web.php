<?php

use Illuminate\Support\Facades\Route;
use Modules\Sale\app\Http\Controllers\SaleCustomerController;
use Modules\Sale\app\Http\Controllers\SaleBookController;

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

        Route::get('book', [SaleBookController::class, 'listBook']);
        Route::get('book/add', [SaleBookController::class, 'addBook']);
        Route::post('book/add', [SaleBookController::class, 'addBookStore']);
        Route::get('book/edit/{uuid}', [SaleBookController::class, 'editBook']);
        Route::post('book/edit/{uuid}', [SaleBookController::class, 'editBookUpdate']);
        Route::get('book/delete/{uuid}', [SaleBookController::class, 'deleteBook']);
        Route::get('book/show/detail/{uuid}', [SaleBookController::class, 'detailBook']);
        Route::get('book/show/detail/print/{uuid}', [SaleBookController::class, 'detailBook']);
    });
});