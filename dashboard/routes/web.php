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
            Route::get('/{id}', 'ProductController@product')->name('product');
            Route::post('/', 'ProductController@postProduct');
        });
        Route::post('delete-product', '\App\Http\Controllers\AdminController@deleteProduct')->name('deleteProduct');
        // seo
        Route::get('seo', 'SeoController@index')->name('seo');
        Route::post('seo', 'SeoController@edit')->name('editSeo');
        // settings
        Route::get('/settings', 'SettingController@index')->name('settings');
        Route::post('/settings', 'SettingController@editSettings');
        // offices
        Route::get('offices', 'OfficeController@index')->name('offices');
        Route::post('offices', 'OfficeController@editOffices');
        Route::post('delete-office', 'OfficeController@deleteOffice');
        // shops
        Route::get('/shops', 'ShopController@index')->name('shops');
        Route::post('/shops', 'ShopController@editShops')->name('editShops');
        Route::post('/delete-shop', 'ShopController@deleteShop')->name('deleteShop');
        // tasting
        Route::get('/tastings', 'TastingController@index')->name('tastings');
        Route::get('/tastings/{id}', 'TastingController@item')->name('tasting');
        Route::post('/tastings/{id}', 'TastingController@postTasting')->name('postTasting');
        Route::post('/tasting-images', 'TastingController@editTastingsImages');
        Route::post('/delete-tasting', 'TastingController@deleteTasting'); // TODO удалить
        Route::post('/delete-tasting-user', 'TastingController@deleteTastingUser');
        // user
        Route::get('/users', 'UserController@users')->name('users');
        Route::post('/user/delete', 'UserController@deleteUser')->name('deleteUser');
        Route::get('/user/{id}', 'UserController@user')->name('user');
        Route::post('/user/{id}', '\App\Http\Controllers\UserController@editUser')->name('postUser');
        // home page
        Route::get('/', 'HomeController@index')->name('home');
    });
});
