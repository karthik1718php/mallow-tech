<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
 
//Billing page
Route::get('/', [ProductController::class, 'index']);

//Generate Invoice
Route::post('invoice', [ProductController::class, 'generateInvoice'])->name('invoice');

//Ajax Fetch product data
Route::get('product-quantity/{id}', [ProductController::class, 'productQuantity'])->name('product-quantity');
