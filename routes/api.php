<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth:sanctum'])->group(function () {

    Route::apiResource('categories', App\Http\Controllers\API\CategoryAPIController::class);
    Route::resource('sub_categories', App\Http\Controllers\API\SubCategoryAPIController::class);
    Route::resource('crops', App\Http\Controllers\API\CropAPIController::class);
    Route::resource('sliders', App\Http\Controllers\API\SliderAPIController::class);
    Route::resource('seller_product_categories', App\Http\Controllers\API\SellerProductCategoryAPIController::class);
    Route::resource('seller_products', App\Http\Controllers\API\SellerProductAPIController::class);
    Route::resource('expense_categories', App\Http\Controllers\API\ExpenseCategoryAPIController::class);
    Route::resource('farms', App\Http\Controllers\API\FarmAPIController::class);


});











