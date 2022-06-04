<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::as('dashboard.')->prefix('dashboard')->group(function() {
    // auth
    Route::get('/login', 'LoginController@showLoginForm')->name('login');
    Route::post('/login', 'LoginController@postLogin')->name('postLogin');
    Route::get('/logout', 'LoginController@logout')->name('logout');

    Route::group(['middleware' => ['auth:dashboard']], function() {
        // order
        Route::group(['prefix' => 'orders'], function() {
            Route::get('/', 'OrderController@list')->name('orders');
            Route::get('/{id}', 'OrderController@item')->name('order');
            Route::put('/item', 'OrderController@putOrder')->name('putOrder');
        });
        // category
        Route::group(['prefix' => 'category'], function() {
            Route::get('/', 'CategoryController@categories')->name('categoryList');
            Route::get('/{id}', 'CategoryController@category')->name('category');
            Route::post('/{id}', 'CategoryController@postCategory')->name('postCategory');
            Route::delete('/delete', 'CategoryController@deleteCategory')->name('deleteCategory');
        });
        // product
        Route::group(['prefix' => 'product'], function() {
            Route::get('/', 'ProductController@productList')->name('products');
            Route::get('/{id}', 'ProductController@productItem')->name('product');
            Route::post('/', 'ProductController@postProduct');

            // Route::get('/products/{slug?}', 'AdminController@products')->name('products');
            // Route::post('/delete-product', 'AdminController@deleteProduct');

        });
        // seo
        Route::get('seo', 'SeoController@index')->name('seo');
        Route::post('seo', 'SeoController@edit')->name('postSeo');
        // home page
        Route::get('/', 'HomeController@index')->name('home');
    });
});
