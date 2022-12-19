<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
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

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/response-password-reset', function () {
    return view('auth.passwords.reset_password');
});


Route::post('password/reset', [App\Http\Controllers\UserForgotPasswordController::class,'reset']);


Auth::routes();

Route::get('/admin-restriction', [App\Http\Controllers\HomeController::class, 'admin'])->name('admin-restriction');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware' => 'admin'], function () {


    Route::resource('roles', App\Http\Controllers\RoleController::class);
    Route::resource('permissions', App\Http\Controllers\PermissionController::class);
    Route::resource('sliders', App\Http\Controllers\SliderController::class);
    Route::resource('countries', App\Http\Controllers\CountryController::class);
    Route::resource('districts', App\Http\Controllers\DistrictController::class);
    Route::resource('farms', App\Http\Controllers\FarmController::class);
    Route::resource('categories', App\Http\Controllers\CategoryController::class);
    Route::resource('crops', App\Http\Controllers\CropController::class);
    Route::resource('plots', App\Http\Controllers\PlotController::class);
    Route::resource('expenseCategories', App\Http\Controllers\ExpenseCategoryController::class);
    Route::resource('expenses', App\Http\Controllers\ExpenseController::class);
    Route::resource('harvests', App\Http\Controllers\HarvestController::class);
    Route::resource('companies', App\Http\Controllers\CompanyController::class);
    Route::resource('subCategories', App\Http\Controllers\SubCategoryController::class);
    Route::resource('sellerProductCategories', App\Http\Controllers\SellerProductCategoryController::class);
    Route::resource('sellerProducts', App\Http\Controllers\SellerProductController::class);
    Route::resource('farmers', App\Http\Controllers\UserController::class);
    Route::get('buyers', [App\Http\Controllers\UserController::class, 'buyers'])->name('buyers');

    //sellers
    Route::get('sellers', [App\Http\Controllers\SellerController::class, 'index'])->name('sellers.index');
    Route::get('sellers/create', [App\Http\Controllers\SellerController::class, 'create'])->name('sellers.create');
    Route::get('sellers/{id}', [App\Http\Controllers\SellerController::class, 'show'])->name('sellers.show');
    Route::get('sellers/{id}/edit', [App\Http\Controllers\SellerController::class, 'edit'])->name('sellers.edit');
    Route::put('sellers/update', [App\Http\Controllers\SellerController::class, 'update'])->name('sellers.update');
    Route::post('sellers/new', [App\Http\Controllers\SellerController::class, 'store'])->name('sellers.store');
    Route::delete('sellers/{id}', [App\Http\Controllers\SellerController::class, 'destroy'])->name('sellers.destroy');


    //admin-profile
    Route::get('admin/profile', [App\Http\Controllers\AdminProfileController::class, 'adminProfile'])->name('admin-profile');


    //buyers
    Route::get('buyers', [App\Http\Controllers\BuyerController::class, 'index'])->name('buyers.index');
    Route::get('buyers/create', [App\Http\Controllers\BuyerController::class, 'create'])->name('buyers.create');
    Route::get('buyers/{id}', [App\Http\Controllers\BuyerController::class, 'show'])->name('buyers.show');
    Route::get('buyers/{id}/edit', [App\Http\Controllers\BuyerController::class, 'edit'])->name('buyers.edit');
    Route::put('buyers/update', [App\Http\Controllers\BuyerController::class, 'update'])->name('buyers.update');
    Route::post('buyers/new', [App\Http\Controllers\BuyerController::class, 'store'])->name('buyers.store');
    Route::delete('buyers/{id}', [App\Http\Controllers\BuyerController::class, 'destroy'])->name('buyers.destroy');


    Route::resource('cropBuyers', App\Http\Controllers\CropOrderController::class);
    Route::resource('cropOnSales', App\Http\Controllers\CropOnSaleController::class);
    Route::resource('cropBuyers', App\Http\Controllers\CropOrderController::class);
    Route::resource('vendorCategories', App\Http\Controllers\VendorCategoryController::class);
    Route::resource('traningVendorServices', App\Http\Controllers\TraningVendorServiceController::class);
    Route::resource('farmerTrainings', App\Http\Controllers\FarmerTrainingController::class);

 });



//google login

Route::get('/auth/google/redirect', function () {
    return Socialite::driver('google')->redirect();
})->name('google');

Route::get('/auth/google/callback',[App\Http\Controllers\GoogleRegisterController::class,'googleCallback'])->name('google-register');



Route::resource('trials', App\Http\Controllers\TrialController::class);


Route::resource('cropHarvests', App\Http\Controllers\CropHarvestController::class);


Route::resource('cropOnSales', App\Http\Controllers\CropOnSaleController::class);


Route::resource('cropOrders', App\Http\Controllers\CropOrderController::class);


Route::resource('trainingVendorServices', App\Http\Controllers\TrainingVendorServiceController::class);


Route::resource('farmerTrainings', App\Http\Controllers\FarmerTrainingController::class);


Route::resource('animalFeedCategories', App\Http\Controllers\AnimalFeedCategoryController::class);


Route::resource('animalFeedSubCategories', App\Http\Controllers\AnimalFeedSubCategoryController::class);


Route::resource('animalFeeds', App\Http\Controllers\AnimalFeedController::class);


Route::resource('tasks', App\Http\Controllers\TaskController::class);
Route::get('task-calender', [App\Http\Controllers\TaskController::class,'taskCalender'])->name('task-calender');


Route::resource('animals', App\Http\Controllers\AnimalController::class);


Route::resource('animalCategories', App\Http\Controllers\AnimalCategoryController::class);


Route::resource('rentVendorCategories', App\Http\Controllers\RentVendorCategoryController::class);


Route::resource('rentVendorSubCategories', App\Http\Controllers\RentVendorSubCategoryController::class);


Route::resource('rentVendorCategories', App\Http\Controllers\RentVendorCategoryController::class);


Route::resource('rentVendorSubCategories', App\Http\Controllers\RentVendorSubCategoryController::class);


Route::resource('rentVendorServices', App\Http\Controllers\RentVendorServiceController::class);


Route::resource('rentVendorServices', App\Http\Controllers\RentVendorServiceController::class);


Route::resource('rentVendorImages', App\Http\Controllers\RentVendorImageController::class);


Route::resource('insuaranceVendorServices', App\Http\Controllers\InsuaranceVendorServiceController::class);


Route::resource('userTypes', App\Http\Controllers\UserTypeController::class);


Route::resource('finaceVendorServices', App\Http\Controllers\FinaceVendorServiceController::class);


Route::resource('onboardings', App\Http\Controllers\OnboardingController::class);


Route::resource('commissions', App\Http\Controllers\CommissionController::class);


Route::resource('vendorCategories', App\Http\Controllers\VendorCategoryController::class);


Route::resource('statuses', App\Http\Controllers\StatusController::class);


Route::resource('financeVendorCategories', App\Http\Controllers\FinanceVendorCategoriesController::class);


Route::resource('periodUnits', App\Http\Controllers\PeriodUnitController::class);


Route::resource('animalCategories', App\Http\Controllers\AnimalCategoryController::class);


Route::resource('userVerifications', App\Http\Controllers\UserVerificationController::class);


Route::resource('loanPlans', App\Http\Controllers\LoanPlanController::class);


Route::resource('loanPayBacks', App\Http\Controllers\LoanPayBackController::class);


Route::resource('chats', App\Http\Controllers\ChatController::class);
