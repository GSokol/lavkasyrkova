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
    // settings
    // Route::group(['prefix' => 'setting'], function() {
    //     Route::post('item', 'SettingsController@postSetting')->name('postSetting');
    //     Route::post('group', 'SettingsController@postSettingGroup')->name('postSettingGroup');
    //     Route::put('form', 'SettingsController@putSettings')->name('putSettings');
    //     Route::delete('item', 'SettingsController@deleteSetting')->name('deleteSetting');
    //     Route::delete('group', 'SettingsController@deleteSettingGroup')->name('deleteSettingGroup');
    // });
    // user
    // Route::group(['prefix' => 'user'], function() {
    //     Route::post('item', 'UserController@postUser')->name('postUser');
    //     Route::get('fetch', 'UserController@getUsers')->name('getUsers');
    // });
    // tasting
    Route::group(['prefix' => 'tasting'], function() {
    //     Route::get('fetch', 'ArticleController@getArticles')->name('getArticles');
    //     Route::post('item', 'ArticleController@postArticle')->name('postArticle');
        Route::delete('tasting-delete', 'TastingController@deleteTasting')->name('deleteTasting');
    });
    // product
    Route::group(['prefix' => 'product'], function() {
        Route::get('suggest', 'ProductController@getProductSuggest')->name('getProductSuggest');
        Route::post('post-product', 'ProductController@postProduct')->name('postProduct');
        Route::post('upload', 'ProductController@postProductImageUpload')->name('postProductImageUpload');
        Route::delete('delete-product', 'ProductController@deleteProduct')->name('deleteProduct');
    });
});
