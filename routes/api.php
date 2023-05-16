<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\OrderController;

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
    Route::post('/flw-webhook',[App\Http\Controllers\API\CollectionController::class,'saveTransaction']);

    Route::post('login/google',[App\Http\Controllers\API\UserAPIController::class,'googleLogin']);
    // Route::any('contact',[App\Http\Controllers\API\UserAPIController::class,'contact'])->middleware('checkUser');
    Route::any('contact',[App\Http\Controllers\API\UserAPIController::class,'contact']);
    Route::any('get_rtc_token',[App\Http\Controllers\API\AccessTokenController::class,'getRtcToken'])->middleware('checkUser');
    Route::any('notifications',[App\Http\Controllers\API\UserAPIController::class,'sendNotice'])
    ->middleware('checkUser');
    Route::any('bind_fcmtoken',[App\Http\Controllers\API\UserAPIController::class,'bind_fcmtoken'])
    ->middleware('checkUser');
    Route::any('send_notice',[App\Http\Controllers\API\UserAPIController::class,'sendNotice'])
    ->middleware('checkUser');
    Route::any('upload_photo',[App\Http\Controllers\API\UserAPIController::class,'upload_photo']);
    // ->middleware('checkUser');


    // transfers
    Route::post('transfer',[App\Http\Controllers\API\PaymentsController::class,'transfer']);
    Route::get('transfers',[App\Http\Controllers\API\PaymentsController::class,'transfers']);

    //content routes
    Route::resource('loan_plans', App\Http\Controllers\API\LoanPlanAPIController::class);
    Route::resource('regions', App\Http\Controllers\API\RegionAPIController::class);
    Route::get('region/{id}/districts',[App\Http\Controllers\API\RegionAPIController::class,'region_districts']);
    Route::resource('districts', App\Http\Controllers\API\DistrictAPIController::class);
    Route::get('users',[App\Http\Controllers\API\UserAPIController::class,'index']);
    Route::get('animal_category/{id}/animal_feeds', [App\Http\Controllers\API\AnimalCategoryAPIController::class,'animal_feed_services']);
    Route::resource('expense_categories', App\Http\Controllers\API\ExpenseCategoryAPIController::class);
    Route::resource('crops', App\Http\Controllers\API\CropAPIController::class);



    //vendor categories with sub categories
    //get all main categories
    //Route::resource('categories', App\Http\Controllers\API\CategoryAPIController::class)->only('index','show');

    Route::group(['prefix' => 'categories'],function () {

        Route::get('/{id}/sub_categories', [App\Http\Controllers\API\CategoryAPIController::class,'category_sub_categories']);//vendors
        Route::get('vendors', [App\Http\Controllers\API\CategoryAPIController::class,'vendor_categories']);//vendors
        Route::get('animals', [App\Http\Controllers\API\AnimalCategoryAPIController::class,'index']);//animals
        Route::get('animals/{id}/animal_feeds', [App\Http\Controllers\API\AnimalCategoryAPIController::class,'animal_feed_service']);//animals feeds
        Route::get('{id}/crops', [App\Http\Controllers\API\CategoryAPIController::class,'category_crops']);//animals feeds

        Route::get('animals/livestock', [App\Http\Controllers\API\AnimalCategoryAPIController::class,'livestock']);
        Route::get('animals/poultry', [App\Http\Controllers\API\AnimalCategoryAPIController::class,'poultry']);
        Route::get('crops', [App\Http\Controllers\API\CategoryAPIController::class,'crop_categories']);//crops
        Route::get('faqs', [App\Http\Controllers\API\CategoryAPIController::class,'faq_categories']);//crops
    });

    Route::group(['prefix' => 'sub_categories'],function () {

        //all sub categories
        Route::get('/farm_equipments', [App\Http\Controllers\API\SellerProductAPIController::class,'farm_equipments_sub_categories']);//farm equipments
        Route::get('/rent_services', [App\Http\Controllers\API\RentVendorServiceAPIController::class,'rent_sub_categories']);//farm equipments
        Route::get('/finance_services', [App\Http\Controllers\API\FinanceVendorServiceAPIController::class,'finance_sub_categories']);//farm equipments
        Route::get('/insurance_services', [App\Http\Controllers\API\InsuaranceVendorServiceAPIController::class,'insurance_sub_categories']);//farm equipments
        Route::get('/training_services', [App\Http\Controllers\API\TrainingVendorServiceAPIController::class,'training_sub_categories']);//trainings
        Route::get('/animal_feeds', [App\Http\Controllers\API\AnimalFeedAPIController::class,'animal_feed_sub_categories']);//animal feeds


        Route::get('/{id}/rent_services', [App\Http\Controllers\API\RentVendorServiceAPIController::class,'rent_services']);//vendors
      //  Route::get('/{id}/animal_feeds', [App\Http\Controllers\API\AnimalFeedsAPIController::class,'animal_feeds']);//vendors
        Route::get('/{id}/training_services', [App\Http\Controllers\API\TrainingVendorServiceAPIController::class,'trainings']);//trainings vendors
        Route::get('/{id}/farm_equipments', [App\Http\Controllers\API\SellerProductAPIController::class,'farm_equipments']);//farm equipments
        Route::get('crop/{id}/agronomists', [App\Http\Controllers\API\AgronomistVendorServiceAPIController::class,'crop_agromonomist_service']);//vendors
        Route::get('/{id}/veterinary', [App\Http\Controllers\API\SellerProductAPIController::class,'farm_equipments']);//vendors
        Route::get('/{id}/finance', [App\Http\Controllers\API\SellerProductAPIController::class,'farm_equipments']);//vendors

    });





    Route::get('market/crops_on_sales', [App\Http\Controllers\API\CropOnSaleAPIController::class,'index']);


    Route::resource('sliders', App\Http\Controllers\API\SliderAPIController::class);
    Route::resource('support/faq-categories', App\Http\Controllers\API\FaqCategoryAPIController::class)->only('index');
    Route::resource('support/faqs', App\Http\Controllers\API\FaqAPIController::class)->only('index');
    Route::resource('app/terms&conditions', App\Http\Controllers\API\TermsAPIController::class)->only('index');
    Route::resource('app/privacy-policies', App\Http\Controllers\API\PrivacyPolicyAPIController::class)->only('index');

    Route::get('seller_products/all', [App\Http\Controllers\API\SellerProductAPIController::class,'index']);


    Route::get('farms', [App\Http\Controllers\API\FarmAPIController::class,'index']);

    //home data
    Route::group(['prefix' => 'home'],function () {
        Route::get('rent_services', [App\Http\Controllers\API\RentVendorServiceAPIController::class,'home_rent_vendors']);
        Route::get('insurance_services', [App\Http\Controllers\API\InsuaranceVendorServiceAPIController::class,'home_insurance_vendors']);
        Route::get('animal_feeds', [App\Http\Controllers\API\AnimalFeedAPIController::class,'home_animal_feeds']);


    });





    //search (
    Route::group(['prefix' => 'search'],function () {
        //home search
        Route::get('/home', [App\Http\Controllers\API\SearchAPIController::class,'home_search']);
        Route::get('/animal-feeds', [App\Http\Controllers\API\AnimalFeedAPIController::class,'animal_feed_search']);
        Route::get('/farm-equipments', [App\Http\Controllers\API\SellerProductAPIController::class,'product_search']);
        Route::get('/farmer-trainings', [App\Http\Controllers\API\TrainingVendorServiceAPIController::class,'training_search']);
        Route::get('/vet-services', [App\Http\Controllers\API\VeterinaryAPIController::class,'vet_search']);
        Route::get('/rent-services', [App\Http\Controllers\API\RentVendorServiceAPIController::class,'rent_search']);
        Route::get('/insurance-services', [App\Http\Controllers\API\InsuaranceVendorServiceAPIController::class,'insuarance_search']);
        Route::get('/agronomist-services', [App\Http\Controllers\API\AgronomistVendorServiceAPIController::class,'agronomist_search']);
        Route::get('/finance-services', [App\Http\Controllers\API\FinanceVendorServiceAPIController::class,'finance_search']);

    });


     //vendor filters
     Route::get('farm_equipments/price_filter', [App\Http\Controllers\API\SellerProductAPIController::class,'price_range']);
     Route::get('farm_equipments/location_filter', [App\Http\Controllers\API\SellerProductAPIController::class,'location_seller_products']);
     Route::get('farm_equipments/asc_order', [App\Http\Controllers\API\SellerProductAPIController::class,'seller_producting_asc_sort']);
     Route::get('farm_equipments/desc_order', [App\Http\Controllers\API\SellerProductAPIController::class,'seller_producting_desc_sort']);


     Route::get('animal_feeds/price_filter', [App\Http\Controllers\API\AnimalFeedAPIController::class,'price_range']);
     Route::get('animal_feeds/location_filter', [App\Http\Controllers\API\AnimalFeedAPIController::class,'location_animal_feeds']);
     Route::get('animal_feeds/asc_order', [App\Http\Controllers\API\AnimalFeedAPIController::class,'animal_feeds_asc_sort']);
     Route::get('animal_feeds/desc_order', [App\Http\Controllers\API\AnimalFeedAPIController::class,'animal_feeds_desc_sort']);


     Route::get('rent_services/price_filter', [App\Http\Controllers\API\RentVendorServiceAPIController::class,'price_range']);
     Route::get('rent_services/location_filter', [App\Http\Controllers\API\RentVendorServiceAPIController::class,'location_rent_services']);
     Route::get('rent_services/asc_order', [App\Http\Controllers\API\RentVendorServiceAPIController::class,'rent_services_asc_sort']);
     Route::get('rent_services/desc_order', [App\Http\Controllers\API\RentVendorServiceAPIController::class,'rent_services_desc_sort']);


     Route::get('insurance_services/location_filter', [App\Http\Controllers\API\InsuaranceVendorServiceAPIController::class,'location_insurance']);
     Route::get('insurance_services/asc_order', [App\Http\Controllers\API\InsuaranceVendorServiceAPIController::class,'insurance_services_asc_sort']);
     Route::get('insurance_services/desc_order', [App\Http\Controllers\API\InsuaranceVendorServiceAPIController::class,'insurance_services_desc_sort']);


     Route::get('training_services/charge_filter', [App\Http\Controllers\API\TrainingVendorServiceAPIController::class,'charge_range']);
     Route::get('training_services/location_filter', [App\Http\Controllers\API\TrainingVendorServiceAPIController::class,'location_training_services']);
     Route::get('training_services/asc_order', [App\Http\Controllers\API\TrainingVendorServiceAPIController::class,'training_services_asc_sort']);
     Route::get('training_services/desc_order', [App\Http\Controllers\API\TrainingVendorServiceAPIController::class,'training_services_desc_sort']);



     Route::get('agronomist_services/charge_filter', [App\Http\Controllers\API\AgronomistVendorServiceAPIController::class,'charge_range']);
     Route::get('agronomist_services/location_filter', [App\Http\Controllers\API\AgronomistVendorServiceAPIController::class,'location_agronomist_services']);
     Route::get('agronomist_services/asc_order', [App\Http\Controllers\API\AgronomistVendorServiceAPIController::class,'agronomist_services_asc_sort']);
     Route::get('agronomist_services/desc_order', [App\Http\Controllers\API\AgronomistVendorServiceAPIController::class,'agronomist_services_desc_sort']);


     Route::get('veterinary_services/charge_filter', [App\Http\Controllers\API\VeterinaryAPIController::class,'charge_range']);
     Route::get('veterinary_services/location_filter', [App\Http\Controllers\API\VeterinaryAPIController::class,'location_veterinary_services']);
     Route::get('veterinary_services/asc_order', [App\Http\Controllers\API\VeterinaryAPIController::class,'veterinary_services_asc_sort']);
     Route::get('veterinary_services/desc_order', [App\Http\Controllers\API\VeterinaryAPIController::class,'veterinary_services_desc_sort']);


     Route::get('finance_services/principal_filter', [App\Http\Controllers\API\FinanceVendorServiceAPIController::class,'principal_range']);
     Route::get('finance_services/location_filter', [App\Http\Controllers\API\FinanceVendorServiceAPIController::class,'location_finance_services']);
     Route::get('finance_services/asc_order', [App\Http\Controllers\API\FinanceVendorServiceAPIController::class,'finance_services_asc_sort']);
     Route::get('finance_services/desc_order', [App\Http\Controllers\API\FinanceVendorServiceAPIController::class,'finance_services_desc_sort']);






      Route::get('veterinaries/all', [App\Http\Controllers\API\VeterinaryAPIController::class,'index']);

    //user registration
    Route::controller(App\Http\Controllers\API\UserAPIController::class)->group(function(){
        Route::post('auth/login','login');

        Route::post('auth/create-account','createNewAccount');
        Route::post('auth/verify-otp','verifyOtp');
        Route::post('auth/send-otp','sendOtp');
        Route::post('auth/check-phone-number','checkPhoneNumber');
        Route::post('auth/check-password','checkPassword');

    });






    //main user forgot password
    Route::post('users/reset-password/email', [App\Http\Controllers\API\ForgotPasswordAPIController::class,'forgotPassword']);
    Route::put('users/password/reset', [App\Http\Controllers\API\ForgotPasswordAPIController::class,'resetPassword']);

    Route::get('/auth/google/callback',[App\Http\Controllers\API\GoogleLoginController::class,'googleCallback']);
    Route::get('/auth/google/login',[App\Http\Controllers\API\GoogleLoginController::class,'redirectToProvider']);


    //google login
    Route::group(['middleware' => ['web']], function () {
        Route::get('/users/google/redirect', function () {
            return Socialite::driver('google')->redirect();
        });
    });



    //protected routes
    Route::middleware(['auth:api','cors'])->group(function () {
        Route::resource('tests', App\Http\Controllers\API\TestAPIController::class);


       //payments
       Route::post('collect',[App\Http\Controllers\API\CollectionController::class,'collect']);
       Route::get('transactions',[App\Http\Controllers\API\CollectionController::class,'transactions']);
       Route::get('transaction/verify/{id}',[App\Http\Controllers\API\CollectionController::class,'verifyTransaction']);
       Route::post('transaction/validate',[App\Http\Controllers\API\CollectionController::class,'validateCharge']);
       Route::post('transaction/resend/{id}',[App\Http\Controllers\API\CollectionController::class,'resendTransaction']);
       Route::post('transaction/refund/{id}',[App\Http\Controllers\API\CollectionController::class,'refundTransaction']);



       Route::post('/pay', [App\Http\Controllers\API\RaveController::class, 'initialize'])->name('pay');
       Route::get('/rave/callback', [App\Http\Controllers\API\RaveController::class, 'callback'])->name('callback');
       //user
        Route::post('user/profile-image/update', [App\Http\Controllers\API\UserAPIController::class,'updateProfileImage']);
        Route::get('user/my-addresses', [App\Http\Controllers\API\AddressAPIController::class,'userAddress']);
        Route::resource('user/address', App\Http\Controllers\API\AddressAPIController::class)->only(['index','store','update','destroy']);

        Route::post('auth/logout',[App\Http\Controllers\API\UserAPIController::class,'userLogOut']);
        Route::post('users/verifications',[App\Http\Controllers\API\UserAPIController::class,'userVerifications']);
        Route::post('account/profile-image',[App\Http\Controllers\API\UserAPIController::class,'updateProfileImage']);

        //farmers

        Route::resource('farms', App\Http\Controllers\API\FarmAPIController::class)->only(['show','store','update','destroy']);
        Route::get('farmer/farms', [App\Http\Controllers\API\FarmAPIController::class,'userFarms']);
        //saved crops on sale
        Route::post('farmer/crops_on_sale/save', [App\Http\Controllers\API\SavedCropOnSaleAPIController::class,'store']);
        Route::delete('farmer/crops_on_sale/unsave/{id}', [App\Http\Controllers\API\SavedCropOnSaleAPIController::class,'destroy']);
        Route::get('/farmer/saved_crops', [App\Http\Controllers\API\SavedCropOnSaleAPIController::class,'saved_crops']);

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
           Route::get('farmer/crop_orders', [App\Http\Controllers\API\CropOrderAPIController::class,'farmer_crop_buy_requests']);
           Route::get('user/crop_orders', [App\Http\Controllers\API\CropOrderAPIController::class,'user_crop_buy_requests']);
           Route::get('crop_order/{id}/accept', [App\Http\Controllers\API\CropOrderAPIController::class,'accept_crop_order']);
           Route::resource('crop_buyer_crop_on_sales', App\Http\Controllers\API\CropOrderCropOnSaleAPIController::class);
           Route::get('crops_on_sale/search', [App\Http\Controllers\API\CropOnSaleAPIController::class,'crop_on_sale_search']);
           Route::get('crop_on_sale/price_filter', [App\Http\Controllers\API\CropOnSaleAPIController::class,'price_range']);
           Route::get('crops_on_sale/home', [App\Http\Controllers\API\CropOnSaleAPIController::class,'home_crops_on_sale']);
           Route::get('crops_on_sale/location', [App\Http\Controllers\API\CropOnSaleAPIController::class,'location_crops']);
        });


        Route::get('/user', [App\Http\Controllers\API\UserAPIController::class,'loggedInUser']);
        Route::get('user/logout',[App\Http\Controllers\API\UserAPIController::class,'userLogOut']);
        Route::post('user/update-details',[App\Http\Controllers\API\UserAPIController::class,'update']);
        Route::post('user/update-password',[App\Http\Controllers\API\UserAPIController::class,'updatePassord']);
        Route::resource('farmers/bought-products', App\Http\Controllers\API\FarmerBuySellerProductAPIController::class);





          //cart
         Route::group(['prefix' => 'cart'],function () {
          Route::get('user/cart_items',[App\Http\Controllers\API\CartItemController::class,'user_cart_items']);
          Route::post('vendor_service/add/{id}',[App\Http\Controllers\API\CartItemController::class,'add_product_to_cart']);
          Route::patch('cart_item/add-qty/{id}',[App\Http\Controllers\API\CartItemController::class,'increase_quantity']);
          Route::patch('cart_item/reduce-qty/{id}',[App\Http\Controllers\API\CartItemController::class,'decrease_quantity']);
          Route::delete('cart_item/delete/{id}',[App\Http\Controllers\API\CartItemController::class,'delete_cart_item']);
          Route::patch('rent-service/add-charge-value/{id}',[App\Http\Controllers\API\CartItemController::class,'increase_charge_value']);
          Route::patch('rent-service/reduce-charge-value/{id}',[App\Http\Controllers\API\CartItemController::class,'reduce_charge_value']);

        });

        //orders
        Route::apiResource('orders', OrderController::class);


        //all vendor groups
        Route::group(['prefix' => 'vendors'],function () {


         //post vendor service
         Route::post('vendor_service/create', [App\Http\Controllers\API\VendorServiceAPIController::class,'store']);
         Route::get('vendor_service/{id}', [App\Http\Controllers\API\VendorServiceAPIController::class,'show']);

          //get all vendor services data

        Route::get('agronomist_vendor_services/all', [App\Http\Controllers\API\VendorServiceAPIController::class,'index']);
        Route::get('insuarance_vendor_services/all', [App\Http\Controllers\API\InsuaranceVendorServiceAPIController::class,'index']);
        Route::get('animal_feeds/all', [App\Http\Controllers\API\AnimalFeedAPIController::class,'index']);
        Route::get('farm_equipments/all', [App\Http\Controllers\API\SellerProductAPIController::class,'index']);
        Route::get('rent_vendor_services/all', [App\Http\Controllers\API\RentVendorServiceAPIController::class,'index']);
        Route::get('training_vendor_services/all', [App\Http\Controllers\API\TrainingVendorServiceAPIController::class,'index']);





          //animal-feeds
          Route::resource('animal-feeds', App\Http\Controllers\API\AnimalFeedAPIController::class)->only(['show','store','update','destroy']);
          Route::get('vendor/animal-feeds', [App\Http\Controllers\API\AnimalFeedAPIController::class,'vendorAnimalFeeds']);

          //training vendor services
          Route::get('vendor/training-vendor-services', [App\Http\Controllers\API\TrainingVendorServiceAPIController::class,'vendorTrainings']);
         // Route::resource('farmer_trainings', App\Http\Controllers\API\FarmerTrainingAPIController::class);
         // Route::post('training-vendor-service/{id}/register', [App\Http\Controllers\API\TrainingVendorServiceAPIController::class,'collect_payment']);
          //Route::get('/training-vendor-service/register/callback', [App\Http\Controllers\API\TrainingVendorServiceAPIController::class,'payment_callback'])->name('registration-callback');


          //loans
          Route::resource('finance-vendor-services', App\Http\Controllers\API\FinanceVendorServiceAPIController::class);
          Route::get('/vendor/finance-vendor-services', [App\Http\Controllers\API\FinanceVendorServiceAPIController::class,'vendor_finance_services']);
          Route::post('/finance/{id}/loans/apply', [App\Http\Controllers\API\LoanApplicationAPIController::class,'store']);
          Route::get('/farmer/loan-applications', [App\Http\Controllers\API\LoanApplicationAPIController::class,'farmer_loan_applications']);
          Route::patch('/loan-application/{id}/approve', [App\Http\Controllers\API\LoanApplicationAPIController::class,'approve_loan']);
          Route::patch('/loan-application/{id}/reject', [App\Http\Controllers\API\LoanApplicationAPIController::class,'reject_loan']);
          Route::get('/vendor/loan-applications', [App\Http\Controllers\API\LoanApplicationAPIController::class,'vendor_loan_applications']);

          //rent services
          Route::get('vendor/rent_vendor_services', [App\Http\Controllers\API\RentVendorServiceAPIController::class,'vendorRentService']);

           //seller products
          Route::resource('farm_equipments', App\Http\Controllers\API\SellerProductAPIController::class)->only(['index','store','update','destroy']);

          Route::get('vendor/farm_equipments', [App\Http\Controllers\API\SellerProductAPIController::class,'vendor_farm_equipments']);


          //insuarance home_insurance_vendors
          Route::resource('insuarance_vendor_services', App\Http\Controllers\API\InsuaranceVendorServiceAPIController::class)->only(['show','store','update','destroy']);
          Route::get('vendor/insurance_vendor_services', [App\Http\Controllers\API\InsuaranceVendorServiceAPIController::class,'vendor_insurance_services']);


           //agronomist service
           Route::resource('agronomist_vendor_services', App\Http\Controllers\API\AgronomistVendorServiceAPIController::class)->only(['store','show','update','destroy']);
           Route::get('agronomist_vendor_services/{id}/schedules',[App\Http\Controllers\API\AgronomistVendorServiceAPIController::class,'agronomist_schedules']);
           Route::get('user/agronomist_services',[App\Http\Controllers\API\AgronomistVendorServiceAPIController::class,'vendor_agro_services']);



          //agronomist shedules
          Route::resource('agronomist_shedules', App\Http\Controllers\API\AgronomistSheduleAPIController::class);
          Route::get('agronomist_shedules/{id}/slots',[App\Http\Controllers\API\AgronomistSheduleAPIController::class,'schedule_slots']);


          //vet
          Route::resource('veterinaries', App\Http\Controllers\API\VeterinaryAPIController::class)->only(['show','store','update','delete']);
          Route::resource('veterinary_shedules', App\Http\Controllers\API\VeterinarySheduleAPIController::class);
          Route::get('vet_service/{id}/schedules',[App\Http\Controllers\API\VeterinaryAPIController::class,'vet_schedules']);
          Route::get('veterinary_shedules/{id}/slots',[App\Http\Controllers\API\VeterinarySheduleAPIController::class,'schedule_slots']);


          Route::get('user/vet_services',[App\Http\Controllers\API\VeterinaryAPIController::class,'vet_services']);





        });






        //support
        Route::resource('support/contact-us', App\Http\Controllers\API\ContactAPIController::class)->only(['store']);

    });


});








//Route::resource('crop_oders', App\Http\Controllers\API\CropOrderAPIController::class);

//Route::resource('crop_orders', App\Http\Controllers\API\CropOrderAPIController::class);

Route::resource('onboardings', App\Http\Controllers\API\OnboardingAPIController::class);












