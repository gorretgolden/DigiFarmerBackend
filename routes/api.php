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





Route::group(['prefix'=>'v1'], function(){

    //content routes
    Route::resource('countries', App\Http\Controllers\API\CountryAPIController::class);
    Route::resource('districts', App\Http\Controllers\API\DistrictAPIController::class);
    Route::get('users',[App\Http\Controllers\API\UserAPIController::class,'index']);

    //user registration
    Route::controller(App\Http\Controllers\API\UserAPIController::class)->group(function(){
        Route::post('users/login','login');
        Route::post('users/create-account','createUserAccount');
        Route::post('users/verify-otp','verifyUserOtp');
        Route::post('users/check-phone-number','checkPhoneNumber');
        Route::post('users/check-password','checkPassword');

    });

    //user forgot password
    Route::post('users/password/email', [App\Http\Controllers\API\ForgotPasswordAPIController::class,'forgotPassword']);
    Route::get('/auth/google/callback',[App\Http\Controllers\API\GoogleLoginController::class,'googleCallback']);


    //google login
    Route::group(['middleware' => ['web']], function () {
        Route::get('/users/google/redirect', function () {
            return Socialite::driver('google')->redirect();
        });
    });



    //protected routes
    Route::middleware(['auth:api','cors'])->group(function () {
        Route::apiResource('categories', App\Http\Controllers\API\CategoryAPIController::class);
        Route::resource('sub_categories', App\Http\Controllers\API\SubCategoryAPIController::class);
        Route::resource('crops', App\Http\Controllers\API\CropAPIController::class);
        Route::resource('sliders', App\Http\Controllers\API\SliderAPIController::class);
        Route::resource('seller_product_categories', App\Http\Controllers\API\SellerProductCategoryAPIController::class);
        Route::resource('seller_products', App\Http\Controllers\API\SellerProductAPIController::class);
        Route::resource('expense_categories', App\Http\Controllers\API\ExpenseCategoryAPIController::class);
        Route::resource('farms', App\Http\Controllers\API\FarmAPIController::class);
        Route::get('farm', [App\Http\Controllers\API\FarmAPIController::class,'farmUser']);
        Route::resource('plots', App\Http\Controllers\API\PlotAPIController::class);
        Route::resource('expenses', App\Http\Controllers\API\ExpenseAPIController::class);
        Route::resource('tasks', App\Http\Controllers\API\TaskAPIController::class);
        Route::get('/user', [App\Http\Controllers\API\UserAPIController::class,'loggedInUser']);
        Route::get('user/logout',[App\Http\Controllers\API\UserAPIController::class,'userLogOut']);
        Route::get('users/update-details/{id}',[App\Http\Controllers\API\UserAPIController::class,'update']);
        Route::resource('farmers/bought-products', App\Http\Controllers\API\FarmerBuySellerProductAPIController::class);
        Route::resource('crop_harvests', App\Http\Controllers\API\CropHarvestAPIController::class);
    });


});















