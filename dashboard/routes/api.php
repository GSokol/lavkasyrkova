<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('api/dashboard')->as('api.dashboard.')->group(function() {
    // home
    // Route::group(['prefix' => 'home'], function() {
    //     Route::get('analytic', 'DashboardController@getAnalyticData')->name('getAnalyticData');
    // });
    // order
    Route::group(['prefix' => 'order'], function() {
        Route::put('item', 'OrderController@putOrder')->name('putOrder');
    });
    // tasting
    Route::group(['prefix' => 'tasting'], function() {
        Route::delete('tasting-delete', 'TastingController@deleteTasting')->name('deleteTasting');
    });
    // product
    Route::group(['prefix' => 'product'], function() {
        Route::get('suggest', 'ProductController@getProductSuggest')->name('getProductSuggest');
        Route::post('post-product', 'ProductController@postProduct')->name('postProduct');
        Route::post('upload', 'ProductController@postProductImageUpload')->name('postProductImageUpload');
        Route::delete('delete-product', 'ProductController@deleteProduct')->name('deleteProduct');
    });
    // media
    Route::group(['prefix' => 'media'], function() {
        Route::post('upload', 'MediaController@postMediaUploadFile')->name('postMediaUploadFile');
        Route::delete('delete', 'MediaController@deleteMedia')->name('deleteMedia');
    });
});
