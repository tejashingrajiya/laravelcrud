<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;


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

//Country         url       
Route::resource('country', CountryController::class);
//                url take to country controller and throw on countryList
Route::post('/country-list', [CountryController::class, 'countryList'])->name('country.list');
Route::get('/country/delete/{country}', [CountryController::class, 'delete'])->name('country.delete');

//state
Route::resource('state',StateController::class);
Route::post('/state-list', [StateController::class, 'stateList'])->name('state.list');
Route::get('/state/delete/{state}', [StateController::class, 'delete'])->name('state.delete');


//city
Route::resource('city', CityController::class);
Route::post('get-states-by-country', [CityController::class, 'getState']);
Route::post('get-cities-by-state', [CityController::class, 'getCity']);
Route::post('/city-list', [CityController::class, 'cityList'])->name('city.list');
Route::get('/city/delete/{city}', [CityController::class, 'delete'])->name('city.delete');

//User
Route::resource('user', UserController::class);
Route::post('/user-list', [UserController::class, 'userList'])->name('user.list');
Route::get('/table', [UserController::class, 'table'])->name('user.list');
Route::get('/user/delete/{user}', [UserController::class, 'delete'])->name('user.delete');

//Product
Route::resource('product', ProductController::class);
Route::post('/product-list', [ProductController::class, ' '])->name('product.list');
Route::get('/product/delete/{product}', [ProductController::class, 'delete'])->name('product.delete');

//Cart
Route::get('cart', [ProductController::class, 'cart'])->name('cart');
Route::patch('update-cart', [ProductController::class, 'updatecart'])->name('updatecart.cart');
Route::get('remove-from-cart', [ProductController::class, 'remove'])->name('remove.from.cart');

//Add To Cart Button
Route::get('add-to-cart/{id}', [ProductController::class, 'addToCart'])->name('addToCart');