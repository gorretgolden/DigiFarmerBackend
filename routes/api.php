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
    Route::resource('categories', App\Http\Controllers\API\CategoryAPIController::class);
    Route::get('crop_category/{id}/crops', [App\Http\Controllers\API\CategoryAPIController::class,'crops']);
    Route::resource('days', App\Http\Controllers\API\DayAPIController::class);


    Route::resource('animal_categories', App\Http\Controllers\API\AnimalCategoryAPIController::class);


    Route::resource('crops', App\Http\Controllers\API\CropAPIController::class);
    Route::get('seller_product_categories', [App\Http\Controllers\API\SellerProductCategoryAPIController::class,'index']);
    Route::resource('expense_categories', App\Http\Controllers\API\ExpenseCategoryAPIController::class);

    //vendor categories with vendor services
    Route::resource('vendor_categories', App\Http\Controllers\API\VendorCategoryAPIController::class)->only(['index','show']);
    Route::get('vendor_categories/{id}/farmer_trainings', [App\Http\Controllers\API\VendorCategoryAPIController::class,'vendor_training_services']);
    Route::get('vendor_categories/{id}/farm_equipments', [App\Http\Controllers\API\VendorCategoryAPIController::class,'vendor_seller_products']);
    Route::get('vendor_categories/{id}/animal_feeds', [App\Http\Controllers\API\VendorCategoryAPIController::class,'vendor_animal_feeds']);
    Route::get('vendor_categories/{id}/insuarance', [App\Http\Controllers\API\VendorCategoryAPIController::class,'vendor_insuarances']);
    Route::get('vendor_categories/{id}/rent', [App\Http\Controllers\API\VendorCategoryAPIController::class,'vendor_rent_services']);
    Route::get('vendor_categories/{id}/agronomists', [App\Http\Controllers\API\VendorCategoryAPIController::class,'vendor_agronomists']);
    Route::get('vendor_categories/{id}/veterinary', [App\Http\Controllers\API\VendorCategoryAPIController::class,'vet_services']);



    Route::resource('animal-feed-categories', App\Http\Controllers\API\AnimalFeedCategoryAPIController::class);
    Route::resource('animal-feed-sub-categories', App\Http\Controllers\API\AnimalFeedSubCategoryAPIController::class);
    Route::get('vendors/training-vendor-services', [App\Http\Controllers\API\TrainingVendorServiceAPIController::class,'index']);

    Route::get('vendors/insuarance_vendor_services/all', [App\Http\Controllers\API\InsuaranceVendorServiceAPIController::class,'index']);
    Route::get('market/crops_on_sales', [App\Http\Controllers\API\CropOnSaleAPIController::class,'index']);

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
    Route::get('rent_vendor_services/all', [App\Http\Controllers\API\RentVendorServiceAPIController::class,'index']);
    Route::get('rent_category/{id}/sub_category', [App\Http\Controllers\API\RentVendorServiceAPIController::class,'rent_sub_categories']);


    //home data
    Route::get('home/rent_services', [App\Http\Controllers\API\RentVendorServiceAPIController::class,'home_rent_vendors']);
    Route::get('home/insurance_services', [App\Http\Controllers\API\InsuaranceVendorServiceAPIController::class,'home_insurance_vendors']);
   //home search
    Route::get('search/home', [App\Http\Controllers\API\SearchAPIController::class,'home_search']);


    //get animal feed categories by animal category
    Route::get('animal-category/{id}/feeds', [App\Http\Controllers\AnimalFeedCategoryController::class,'animal_category_feeds'] );

    Route::get('rent_vendor_categories', [App\Http\Controllers\API\RentVendorCategoryAPIController::class,'index']);


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

        Route::resource('farms', App\Http\Controllers\API\FarmAPIController::class)->only(['show','store','update','destroy']);
        Route::get('farmer/farms', [App\Http\Controllers\API\FarmAPIController::class,'userFarms']);
        //saved crops on sale
        Route::resource('farmer/saved_crop_on_sales', App\Http\Controllers\API\SavedCropOnSaleAPIController::class);
        Route::get('saved_crops/farmer', [App\Http\Controllers\API\SavedCropOnSaleAPIController::class,'saved_crops']);

        //farm endpoints
        Route::group(['prefix' => 'farm'],function () {

            Route::get('farmer/plots', [App\Http\Controllers\API\PlotAPIController::class,'farmPlots']);
            Route::resource('plots', App\Http\Controllers\API\PlotAPIController::class);
            Route::resource('plot/animals', App\Http\Controllers\API\AnimalAPIController::class)->only(['store','update','show','destroy']);
            Route::resource('plot/expenses', App\Http\Controllers\API\ExpenseAPIController::class);
            Route::resource('plot/tasks', App\Http\Controllers\API\TaskAPIController::class);
            Route::resource('plot/crop_harvests', App\Http\Controllers\API\CropHarvestAPIController::class);
            Route::get('plot/{id}/expenses',[App\Http\Controllers\API\PlotAPIController::class,'expenses_on_plot'] );
            Route::get('plot/{id}/tasks',[App\Http\Controllers\API\PlotAPIController::class,'tasks_on_plot'] );
            Route::get('plot/{id}/animals', [App\Http\Controllers\API\PlotAPIController::class,'animals_on_plot']);
            Route::get('plot/{id}/crop_harvests', [App\Http\Controllers\API\PlotAPIController::class,'crop_harvests_on_plot']);
            Route::get('{id}/plots', [App\Http\Controllers\API\FarmAPIController::class,'farm_plots']);

        });



        //market endpoints
        Route::group(['prefix' => 'market'],function () {
               //crops on sale
           Route::get('farmer/crops_on_sale', [App\Http\Controllers\API\CropOnSaleAPIController::class,'famerCropsOnSale']);
           Route::resource('crops_on_sales', App\Http\Controllers\API\CropOnSaleAPIController::class)->only(['store','update','destroy','show']);
           Route::get('crops_on_sale/{id}/requests', [App\Http\Controllers\API\CropOnSaleAPIController::class,'crop_buy_requests']);
           Route::get('crop_category/{id}/crops_on_sale', [App\Http\Controllers\API\CropOnSaleAPIController::class,'crop_on_sale_category']);
           Route::get('crop-buyers/crops', [App\Http\Controllers\API\CropOrderAPIController::class,'getCropBuyerCropOnSales']);
           Route::post('crop_buy_request/{id}', [App\Http\Controllers\API\CropOrderAPIController::class,'buyCropOnSale']);
           Route::get('crop_buyers', [App\Http\Controllers\API\CropOrderAPIController::class,'index']);
           Route::get('crop_buyers/{id}', [App\Http\Controllers\API\CropOrderAPIController::class,'show']);
           Route::resource('crop_buyer_crop_on_sales', App\Http\Controllers\API\CropOrderCropOnSaleAPIController::class);



        });


        Route::get('/user', [App\Http\Controllers\API\UserAPIController::class,'loggedInUser']);
        Route::get('user/logout',[App\Http\Controllers\API\UserAPIController::class,'userLogOut']);
        Route::get('users/update-details/{id}',[App\Http\Controllers\API\UserAPIController::class,'update']);
        Route::resource('farmers/bought-products', App\Http\Controllers\API\FarmerBuySellerProductAPIController::class);




        //all vendor groups
        Route::group(['prefix' => 'vendors'],function () {
          //animal-feeds
          Route::resource('animal-feeds', App\Http\Controllers\API\AnimalFeedAPIController::class)->only(['show','store','update','destroy']);
          Route::get('vendor/animal-feeds', [App\Http\Controllers\API\AnimalFeedAPIController::class,'vendorAnimalFeeds']);

          //training vendor services
          Route::resource('training-vendor-services', App\Http\Controllers\API\TrainingVendorServiceAPIController::class)->only(['store','show','update','destroy']);
          Route::get('vendor/training-vendor-services', [App\Http\Controllers\API\TrainingVendorServiceAPIController::class,'vendorTrainings']);
          Route::resource('farmer_trainings', App\Http\Controllers\API\FarmerTrainingAPIController::class);

          //loans
          Route::resource('finance-vendor-services', App\Http\Controllers\API\FinanceVendorServiceAPIController::class);

          //rent services
          Route::resource('rent_vendor_services', App\Http\Controllers\API\RentVendorServiceAPIController::class)->only(['show','store','update','destroy']);
          Route::get('vendor/rent_vendor_services', [App\Http\Controllers\API\RentVendorServiceAPIController::class,'vendorRentService']);

           //seller products
          Route::resource('farm_equipments', App\Http\Controllers\API\SellerProductAPIController::class)->only(['store','show','update','destroy']);

          Route::get('vendor/farm_equipments', [App\Http\Controllers\API\SellerProductAPIController::class,'vendor_farm_equipments']);


          //insuarance home_insurance_vendors
          Route::resource('insuarance_vendor_services', App\Http\Controllers\API\InsuaranceVendorServiceAPIController::class)->only(['show','store','update','destroy']);
          Route::get('vendor/insuarance_vendor_services', [App\Http\Controllers\API\InsuaranceVendorServiceAPIController::class,'vendor_insurance_services']);


           //agronomist service
           Route::resource('agronomist_vendor_services', App\Http\Controllers\API\AgronomistVendorServiceAPIController::class);
           Route::get('agronomist_vendor_services/{id}/schedules',[App\Http\Controllers\API\AgronomistVendorServiceAPIController::class,'agronomist_schedules']);
           Route::get('user/agronomist_services',[App\Http\Controllers\API\AgronomistVendorServiceAPIController::class,'vendor_agro_services']);



          //agronomist shedules
          Route::resource('agronomist_shedules', App\Http\Controllers\API\AgronomistSheduleAPIController::class);
          Route::get('agronomist_shedules/{id}/slots',[App\Http\Controllers\API\AgronomistSheduleAPIController::class,'schedule_slots']);


          //vet
          Route::resource('veterinaries', App\Http\Controllers\API\VeterinaryAPIController::class);
          Route::resource('veterinary_shedules', App\Http\Controllers\API\VeterinarySheduleAPIController::class);
          Route::get('vet_service/{id}/schedules',[App\Http\Controllers\API\VeterinaryAPIController::class,'vet_schedules']);
          Route::get('veterinary_shedules/{id}/slots',[App\Http\Controllers\API\VeterinarySheduleAPIController::class,'schedule_slots']);


          Route::get('user/vet_services',[App\Http\Controllers\API\VeterinaryAPIController::class,'vet_services']);





        });



        //search for animal feed by name
        Route::get('animal-feeds/search/{name}', [App\Http\Controllers\API\AnimalFeedAPIController::class,'search_animal_feed_by_name']);






        //support
        Route::resource('support/contact-us', App\Http\Controllers\API\ContactAPIController::class)->only(['store']);

    });


});


Route::post('/pay', [App\Http\Controllers\API\RaveController::class, 'initialize'])->name('pay');
Route::get('/rave/callback', [App\Http\Controllers\API\RaveController::class, 'callback'])->name('callback');




Route::resource('farmer_finance_applications', App\Http\Controllers\API\FarmerFinanceApplicationAPIController::class);

//Route::resource('crop_oders', App\Http\Controllers\API\CropOrderAPIController::class);

//Route::resource('crop_orders', App\Http\Controllers\API\CropOrderAPIController::class);

Route::resource('onboardings', App\Http\Controllers\API\OnboardingAPIController::class);


















