<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


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
