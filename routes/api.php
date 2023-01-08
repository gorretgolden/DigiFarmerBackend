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


    Route::resource('animal_categories', App\Http\Controllers\API\AnimalCategoryAPIController::class);


    Route::resource('crops', App\Http\Controllers\API\CropAPIController::class);
    Route::get('seller_product_categories', [App\Http\Controllers\API\SellerProductCategoryAPIController::class,'index']);
    Route::resource('expense_categories', App\Http\Controllers\API\ExpenseCategoryAPIController::class);

    //vendor categories
    Route::resource('vendor_categories', App\Http\Controllers\API\VendorCategoryAPIController::class)->only(['index','show']);
    Route::get('vendor_categories/{id}/farmer_trainings', [App\Http\Controllers\API\VendorCategoryAPIController::class,'vendor_training_services']);
    Route::get('vendor_categories/{id}/farm_equipments', [App\Http\Controllers\API\VendorCategoryAPIController::class,'vendor_seller_products']);
    Route::get('vendor_categories/{id}/animal_feeds', [App\Http\Controllers\API\VendorCategoryAPIController::class,'vendor_animal_feeds']);
    Route::get('vendor_categories/{id}/insuarance', [App\Http\Controllers\API\VendorCategoryAPIController::class,'vendor_insuarances']);



    Route::resource('animal-feed-categories', App\Http\Controllers\API\AnimalFeedCategoryAPIController::class);
    Route::resource('animal-feed-sub-categories', App\Http\Controllers\API\AnimalFeedSubCategoryAPIController::class);
    Route::get('vendors/training-vendor-services', [App\Http\Controllers\API\TrainingVendorServiceAPIController::class,'index']);

    Route::get('vendors/insuarance_vendor_services', [App\Http\Controllers\API\InsuaranceVendorServiceAPIController::class,'index']);
    Route::get('market/crops_on_sales', [App\Http\Controllers\API\CropOnSaleAPIController::class]);

    Route::get('sub-categories/crops-on-sale/{id}', [App\Http\Controllers\API\SubCategoryAPIController::class,'showCropsOnSale']);
    Route::resource('user-types', App\Http\Controllers\API\UserTypeAPIController::class);
    Route::resource('sliders', App\Http\Controllers\API\SliderAPIController::class);
    Route::resource('support/faq-categories', App\Http\Controllers\API\FaqCategoryAPIController::class)->only('index');
    Route::resource('support/faqs', App\Http\Controllers\API\FaqAPIController::class)->only('index');
    Route::resource('app/terms&conditions', App\Http\Controllers\API\TermsAPIController::class)->only('index');
    Route::resource('app/privacy-policies', App\Http\Controllers\API\PrivacyPolicyAPIController::class)->only('index');

    Route::resource('statuses', App\Http\Controllers\API\StatusAPIController::class);
    Route::get('seller_products/all', [App\Http\Controllers\API\SellerProductAPIController::class,'index']);


    Route::get('farms', [App\Http\Controllers\API\FarmAPIController::class,'index']);
    Route::get('animal_feeds/all', [App\Http\Controllers\API\AnimalFeedAPIController::class,'index']);

    //user registration
    Route::controller(App\Http\Controllers\API\UserAPIController::class)->group(function(){
        Route::post('auth/login','login');

        Route::post('auth/create-account','createNewAccount');
        Route::post('auth/verify-otp','verifyOtp');
        Route::post('auth/send-otp','sendOtp');
        Route::post('auth/check-phone-number','checkPhoneNumber');
        Route::post('auth/check-password','checkPassword');

    });


  //password request
  Route::post('password/email', [App\Http\Controllers\UserForgotPasswordController::class,'forgot']);
  Route::post('password/reset', [App\Http\Controllers\UserForgotPasswordController::class,'reset']);




    //user forgot password
    Route::post('users/password/email', [App\Http\Controllers\API\ForgotPasswordAPIController::class,'forgotPassword']);
    Route::get('/auth/google/callback',[App\Http\Controllers\API\GoogleLoginController::class,'googleCallback']);


    //google login
    Route::group(['middleware' => ['web']], function () {
        Route::get('/users/google/redirect', function () {
            return Socialite::driver('google')->redirect();
        });
    });


    Route::post('sendPasswordResetLink',[App\Http\Controllers\UserForgotPasswordController::class, 'sendEmail']);
    Route::post('resetPassword',[App\Http\Controllers\ChangePasswordController::class, 'passwordResetProcess']);


    //protected routes
    Route::middleware(['auth:api','cors'])->group(function () {

        //user
        Route::post('user/profile/update/{id}', [App\Http\Controllers\API\UserAPIController::class,'update']);
        Route::patch('user/profile-image/update/{id}', [App\Http\Controllers\API\UserAPIController::class,'updateProfileImage']);
        Route::get('user/my-addresses', [App\Http\Controllers\API\AddressAPIController::class,'userAddress']);
        Route::resource('user/address', App\Http\Controllers\API\AddressAPIController::class)->only(['index','store','update','destroy']);

        Route::post('auth/logout',[App\Http\Controllers\API\UserAPIController::class,'userLogOut']);
        Route::post('users/verifications',[App\Http\Controllers\API\UserAPIController::class,'userVerifications']);
        Route::post('users/wallet',[App\Http\Controllers\API\UserAPIController::class,'userWallet']);
        Route::post('account/profile-image',[App\Http\Controllers\API\UserAPIController::class,'updateProfileImage']);

        //farmers

        Route::resource('farms', App\Http\Controllers\API\FarmAPIController::class)->only(['store','update','destroy']);


        Route::get('farmer/farms', [App\Http\Controllers\API\FarmAPIController::class,'userFarms']);
        Route::get('farmer/plots', [App\Http\Controllers\API\PlotAPIController::class,'farmPlots']);

        Route::resource('plots', App\Http\Controllers\API\PlotAPIController::class);
        Route::get('plot/{id}/expenses',[App\Http\Controllers\API\PlotAPIController::class,'plot_expenses'] );
        Route::get('plot/{id}/tasks',[App\Http\Controllers\API\PlotAPIController::class,'plot_tasks'] );
        Route::get('plot/{id}/crop_harvests', [App\Http\Controllers\API\PlotAPIController::class,'getTotalHarvestForPlot']);
        Route::get('plot/{id}/animals', [App\Http\Controllers\API\PlotAPIController::class,'animals_on_plot']);

        Route::get('farm/{id}/plots', [App\Http\Controllers\API\FarmAPIController::class,'farm_plots']);
        Route::resource('farm/animals', App\Http\Controllers\API\AnimalAPIController::class)->only(['store','update','show','destroy']);

        Route::resource('expenses', App\Http\Controllers\API\ExpenseAPIController::class);
        Route::get('plot/expenses', [App\Http\Controllers\API\ExpenseAPIController::class,'expensePlots']);

        Route::resource('tasks', App\Http\Controllers\API\TaskAPIController::class);


        //crops on sale
        Route::get('market/farmer/crops_on_sale', [App\Http\Controllers\API\CropOnSaleAPIController::class,'famerCropsOnSale']);
        Route::resource('market/crops_on_sales', App\Http\Controllers\API\CropOnSaleAPIController::class)->only(['store','update','destroy','show']);

        Route::get('/user', [App\Http\Controllers\API\UserAPIController::class,'loggedInUser']);
        Route::get('user/logout',[App\Http\Controllers\API\UserAPIController::class,'userLogOut']);
        Route::get('users/update-details/{id}',[App\Http\Controllers\API\UserAPIController::class,'update']);
        Route::resource('farmers/bought-products', App\Http\Controllers\API\FarmerBuySellerProductAPIController::class);
        Route::resource('plot/crop_harvests', App\Http\Controllers\API\CropHarvestAPIController::class);

        //seller products
        Route::resource('vendors/seller_products', App\Http\Controllers\API\SellerProductAPIController::class);

        Route::resource('insuarance_vendor_services', App\Http\Controllers\API\InsuaranceVendorServiceAPIController::class)->only(['show','store','update','destroy']);

        Route::get('crop-harvests/{id}/total-harvest', [App\Http\Controllers\API\CropHarvestAPIController::class,'getTotalHarvestForPlot']);


        Route::get('market/crop-buyers/crops', [App\Http\Controllers\API\CropOrderAPIController::class,'getCropBuyerCropOnSales']);
        Route::post('market/buy_crop/{id}', [App\Http\Controllers\API\CropOrderAPIController::class,'buyCropOnSale']);
        Route::get('market/crop_buyers', [App\Http\Controllers\API\CropOrderAPIController::class,'index']);
        Route::get('market/crop_buyers/{id}', [App\Http\Controllers\API\CropOrderAPIController::class,'show']);
        Route::resource('crop_buyer_crop_on_sales', App\Http\Controllers\API\CropOrderCropOnSaleAPIController::class);

        Route::resource('crop_buyer_crop_on_sales', App\Http\Controllers\API\CropBuyerCropOnSaleAPIController::class);

        //training vendor services
        Route::resource('vendors/training-vendor-services', App\Http\Controllers\API\TrainingVendorServiceAPIController::class)->only(['store','show','update','destroy']);
        Route::get('vendors/vendor/training-vendor-services', [App\Http\Controllers\API\TrainingVendorServiceAPIController::class,'vendorTrainings']);

        Route::resource('farmer_trainings', App\Http\Controllers\API\FarmerTrainingAPIController::class);
        Route::resource('vendors/finance-vendor-services', App\Http\Controllers\API\FinanceVendorServiceAPIController::class);

        //animal-feeds
        Route::resource('animal-feeds', App\Http\Controllers\API\AnimalFeedAPIController::class)->only(['show','store','update','destroy']);
        Route::get('vendor/animal-feeds', [App\Http\Controllers\API\AnimalFeedAPIController::class,'vendorAnimalFeeds']);



        //support
        Route::resource('support/contact-us', App\Http\Controllers\API\ContactAPIController::class)->only(['store']);

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

Route::resource('onboardings', App\Http\Controllers\API\OnboardingAPIController::class);



