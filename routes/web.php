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

    Route::resource('users', 'UserController');

    Route::resource('categories', 'CategoryController');

    Route::resource('products', 'ProductController');
});
