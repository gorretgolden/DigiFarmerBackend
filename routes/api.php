<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

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

Route::middleware(['auth:api'])->prefix('v1')->group(function () {

    Route::apiResource('categories', App\Http\Controllers\API\CategoryAPIController::class);
    Route::resource('sub_categories', App\Http\Controllers\API\SubCategoryAPIController::class);
    Route::resource('crops', App\Http\Controllers\API\CropAPIController::class);
    Route::resource('sliders', App\Http\Controllers\API\SliderAPIController::class);
    Route::resource('seller_product_categories', App\Http\Controllers\API\SellerProductCategoryAPIController::class);
    Route::resource('seller_products', App\Http\Controllers\API\SellerProductAPIController::class);
    Route::resource('expense_categories', App\Http\Controllers\API\ExpenseCategoryAPIController::class);
    Route::resource('farms', App\Http\Controllers\API\FarmAPIController::class);
    Route::resource('plots', App\Http\Controllers\API\PlotAPIController::class);
    Route::resource('expenses', App\Http\Controllers\API\ExpenseAPIController::class);



});


Route::controller(App\Http\Controllers\API\UserAPIController::class)->prefix('v1')->group(function(){
    Route::post('users/login','login');
    Route::post('users/register','register');
    Route::get('users','index');
    Route::get('users/details/{id}','show');
    Route::put('users/update/{id}','register');
    Route::get('user/logout','logout');

});

Route::group(['middleware' => ['api', 'auth:api']], function(){

});

// Route::post('email/verification-notification', [EmailVerificationController::class, 'sendVerificationEmail'])->middleware('auth:sanctum');
// Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify')->middleware('auth:sanctum');



Route::post('users/forgot-password', [App\Http\Controllers\API\NewPasswordController::class, 'userForgotPassword']);
Route::post('reset-password', [App\Http\Controllers\API\NewPasswordController::class, 'reset']);

//google login

Route::get('/auth/google/redirect', function () {
    return Socialite::driver('google')->redirect();
});









// Route::resource('users', App\Http\Controllers\API\UserAPIController::class);




