<?php

use Illuminate\Support\Facades\Auth;
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
Auth::routes();

Route::group(['middleware' => 'locale'], function() {
    Route::get('lang/{lang}', 'LangController@changeLanguage')->name('lang');
});

//Admin Route
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('dashboard', 'AdminController@index')->name('dashboard');

    Route::get('get-chart', 'AdminController@getChart');

    Route::resource('users', 'UserController');

    Route::resource('categories', 'CategoryController');

    Route::resource('products', 'ProductController');

    Route::resource('orders', 'OrderController');

    Route::put('show-notification', 'AdminController@getNotification');
});

//Client Route
Route::get('homepage', 'HomeController@index')->name('homepage');

Route::resource('shopping', 'ShoppingController');

//Cart Route
Route::resource('cart', 'CartController');

Route::post('add-cart/{id}', 'CartController@addCart')->name('add_cart');

Route::post('shopping/add-cart/{id}', 'CartController@addCart')->name('add_cart');

Route::put('cart/cart/{id}', 'CartController@update');

Route::get('clear-cart', 'CartController@clearCart')->name('clear_cart');

//Favourites Route
Route::get('/favourites', 'FavouriteController@index')->name('favourites');

Route::post('add-to-favourites/{id}', 'FavouriteController@addToFavourites')->name('add_to_favourites');

Route::post('shopping/add-to-favourites/{id}', 'FavouriteController@addToFavourites')->name('add_to_favourites');

Route::put('favourites/{id}', 'FavouriteController@update');

Route::get('clear-favourites', 'FavouriteController@clearFavourites')->name('clear_favourites');

Route::delete('favourites/{id}', 'FavouriteController@destroy')->name('favourites_destroy');

//Checkout Route
Route::resource('checkout', 'CheckoutController');

//Suggest Route
Route::get('contact-us', 'SuggestController@create')->name('contact_us');
Route::resource('suggests', 'SuggestController');

//My Account Route
Route::resource('profile', 'ProfileController');

//History Order
Route::get('history-order', 'OrderController@historyOrder')->name('history_order');
Route::put('cancel-order/{id}', 'OrderController@cancelOrder');

//Rating
Route::resource('rating', 'RatingController');

//Show order details
Route::get('show-details/orders/{id}', 'OrderController@showDetails')->name('show_details');
