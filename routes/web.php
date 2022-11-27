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
    Route::resource('users', App\Http\Controllers\UserController::class);
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
});

Route::get('/auth/google/callback',[App\Http\Controllers\GoogleRegisterController::class,'googleCallback'])->name('google-register');



Route::resource('trials', App\Http\Controllers\TrialController::class);


Route::resource('cropHarvests', App\Http\Controllers\CropHarvestController::class);


Route::resource('cropOnSales', App\Http\Controllers\CropOnSaleController::class);


Route::resource('cropOrders', App\Http\Controllers\CropOrderController::class);
