<?php

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

Route::get('/', ['as' => 'currency::index', 'uses' => 'CurrencyController@index']);
Route::get('/about', ['as' => 'currency::about', 'uses' => 'CurrencyController@about']);

Route::group(['prefix' => 'currency', 'as' => 'currency::'], function() {
    Route::get('{currency}', ['as' => 'detail', 'uses' => 'CurrencyDetailController@index']);
    Route::get('/', ['as' => 'list', 'uses' => 'CurrencyController@list']);
});

Route::group(['prefix' => 'api', 'middleware' => 'throttle', 'as' => 'api::'], function () {
    Route::get('currency/dinamic/{date1}/{date2}/{currencyCode?}',['as' => 'dinamic', 'uses' => 'ApiCurrencyController@getDinamic']);
    Route::get('currency/codes/{code?}', 'ApiCurrencyController@getCodes');
    Route::get('currency/{daily}/{date_req?}/{currencyCharCode?}', ['uses' => 'ApiCurrencyController@getCurrency', 'as' => 'daily']);
    Route::get('currency', 'ApiCurrencyController@getCurrency');
});
