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
    Route::apiResource('categories', App\Http\Controllers\API\CategoryAPIController::class);
    Route::resource('sub_categories', App\Http\Controllers\API\SubCategoryAPIController::class);
    Route::resource('crops', App\Http\Controllers\API\CropAPIController::class);
    Route::resource('seller_product_categories', App\Http\Controllers\API\SellerProductCategoryAPIController::class);
    Route::resource('expense_categories', App\Http\Controllers\API\ExpenseCategoryAPIController::class);
    Route::resource('vendor_categories', App\Http\Controllers\API\VendorCategoryAPIController::class);
    Route::resource('animal-feed-categories', App\Http\Controllers\API\AnimalFeedCategoryAPIController::class);
    Route::resource('animal-feed-sub-categories', App\Http\Controllers\API\AnimalFeedSubCategoryAPIController::class);


    //user registration
    Route::controller(App\Http\Controllers\API\UserAPIController::class)->group(function(){
        Route::post('users/login','login');
        Route::post('users/create-account','store');
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

        Route::resource('sliders', App\Http\Controllers\API\SliderAPIController::class);
        Route::resource('seller_products', App\Http\Controllers\API\SellerProductAPIController::class);

        Route::resource('farms', App\Http\Controllers\API\FarmAPIController::class);
        Route::get('farmer/farms', [App\Http\Controllers\API\FarmAPIController::class,'user_farms']);
        Route::get('farmer/plots', [App\Http\Controllers\API\PlotAPIController::class,'farmPlots']);
        Route::get('farm/owner', [App\Http\Controllers\API\FarmAPIController::class,'farmUser']);
        Route::resource('plots', App\Http\Controllers\API\PlotAPIController::class);
        Route::get('farms/{id}/plots', [App\Http\Controllers\API\PlotAPIController::class,'plots_on_farm']);
        Route::resource('expenses', App\Http\Controllers\API\ExpenseAPIController::class);
        Route::resource('tasks', App\Http\Controllers\API\TaskAPIController::class);
        Route::get('/user', [App\Http\Controllers\API\UserAPIController::class,'loggedInUser']);
        Route::get('user/logout',[App\Http\Controllers\API\UserAPIController::class,'userLogOut']);
        Route::get('users/update-details/{id}',[App\Http\Controllers\API\UserAPIController::class,'update']);
        Route::resource('farmers/bought-products', App\Http\Controllers\API\FarmerBuySellerProductAPIController::class);
        Route::resource('crop_harvests', App\Http\Controllers\API\CropHarvestAPIController::class);

        Route::get('crop-harvests/{id}/total-harvest', [App\Http\Controllers\API\CropHarvestAPIController::class,'getTotalHarvestForPlot']);
        Route::resource('market/crops_on_sales', App\Http\Controllers\API\CropOnSaleAPIController::class);
        Route::get('market/crop-buyers/crops', [App\Http\Controllers\API\CropOrderAPIController::class,'getCropBuyerCropOnSales']);
        Route::post('market/buy_crop/{id}', [App\Http\Controllers\API\CropOrderAPIController::class,'buyCropOnSale']);
        Route::get('market/crop_buyers', [App\Http\Controllers\API\CropOrderAPIController::class,'index']);
        Route::get('market/crop_buyers/{id}', [App\Http\Controllers\API\CropOrderAPIController::class,'show']);
        Route::resource('crop_buyer_crop_on_sales', App\Http\Controllers\API\CropOrderCropOnSaleAPIController::class);

        Route::resource('crop_buyer_crop_on_sales', App\Http\Controllers\API\CropBuyerCropOnSaleAPIController::class);
        Route::resource('training_vendor_services', App\Http\Controllers\API\TrainingVendorServiceAPIController::class);
        Route::resource('farmer_trainings', App\Http\Controllers\API\FarmerTrainingAPIController::class);
        Route::resource('finance_vendor_services', App\Http\Controllers\API\FinanceVendorServiceAPIController::class);
        Route::resource('animal-feeds', App\Http\Controllers\API\AnimalFeedAPIController::class);
        Route::get('vendor/animal-feeds', [App\Http\Controllers\API\AnimalFeedAPIController::class,'vendorAnimalFeeds']);




    });


});



// Route::get('/concat-table', function(){
//     $crops_on_sale = App\Models\CropOnSale::all();
//     $crop_orders = App\Models\CropOrder::get();
//     $data = $crops_on_sale->concat($crop_orders);
//     return $data;
// });


Route::get('/get-data', function(){
    $data = DB::table('crop_on_sales')
        ->join('crop_on_sale_crop_order', 'crop_on_sales.id', '=', 'crop_on_sale_crop_order.crop_on_sale_id')
        ->select('crop_on_sales.*', 'crop_on_sale_crop_order.crop_order_id')
        ->get();
    dd($data);
});



















Route::resource('farmer_finance_applications', App\Http\Controllers\API\FarmerFinanceApplicationAPIController::class);


//Route::resource('crop_oders', App\Http\Controllers\API\CropOrderAPIController::class);


//Route::resource('crop_orders', App\Http\Controllers\API\CropOrderAPIController::class);









