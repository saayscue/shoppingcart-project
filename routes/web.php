<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', ['uses' => '\App\Http\Controllers\ProductsController@index']);
Route::get('/products/{sku}', ['uses' => '\App\Http\Controllers\ProductsController@get']);

Route::get('/admin/products', ['uses' => '\App\Http\Controllers\ProductsController@admin_index']);
Route::post('/admin/products/add', ['uses' => '\App\Http\Controllers\ProductsController@admin_products_add']);
Route::post('/admin/products', ['uses' => '\App\Http\Controllers\ProductsController@admin_products_delete']);
Route::get('/admin/order', ['uses' => '\App\Http\Controllers\OrdersController@admin_order']);

Route::get('/admin/products/edit/{sku}', ['uses' => '\App\Http\Controllers\ProductsController@admin_product_edit']);
Route::post('/admin/products/update', ['uses' => '\App\Http\Controllers\ProductsController@admin_products_update']);

Route::post('/products/{sku}', ['uses' => '\App\Http\Controllers\CartsController@addProductToCart']);
Route::get('/cart', ['uses' => '\App\Http\Controllers\CartsController@cartIndex']);
Route::post('/cart', ['uses' => '\App\Http\Controllers\CartsController@removeProductFromCart']);
Route::post('/cart/update', ['uses' => '\App\Http\Controllers\CartsController@updateQuantity']);

Route::get('/checkout', ['uses' => '\App\Http\Controllers\OrdersController@showCheckoutForm']);
Route::post('/checkout', ['uses' => '\App\Http\Controllers\OrdersController@collectShippingInfo']);