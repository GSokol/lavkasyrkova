<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::as('face.')->group(function() {
    // auth
    Route::group(['namespace' => 'Auth'], function() {
        Route::get('/login', 'LoginController@showLoginForm')->name('login');
        Route::post('/login', 'LoginController@postLogin')->name('postLogin');
        Route::get('/logout', 'LoginController@logout')->name('logout');
        Route::get('/register', 'RegisterController@showRegistrationForm')->name('register');
        Route::post('/register', 'RegisterController@register')->name('postRegistration');
    });
    // profile
    Route::group(['prefix' => 'profile', 'middleware' => ['auth:web']], function() {
        Route::get('/', 'UserController@index');
        Route::get('/user', 'UserController@user');
        Route::post('/user', 'UserController@editUser');
        Route::post('/checkout-order', 'UserController@checkoutOrder');
        Route::post('/signing-tasting', 'UserController@signingTasting');
        // orders
        Route::group(['prefix' => 'orders'], function() {
            Route::get('/', 'UserController@orders')->name('orders');
            Route::post('/repeat', 'OrderController@postOrderRepeat')->name('postOrderRepeat');
            Route::delete('/item', 'OrderController@deleteOrder')->name('deleteOrder');
        });
    });
    // catalog
    Route::group(['prefix' => 'category'], function() {
        Route::get('/', 'CatalogController@index')->name('catalog');
        Route::get('/{slug}', 'CatalogController@category')->name('category');
    });
    // basket
    Route::post('/basket', 'BasketController@editBasket');
    Route::post('/empty-basket', 'BasketController@emptyBasket');
    Route::post('/checkout-order', 'BasketController@checkoutOrder');
    // mail
    Route::get('/send-confirm-mail', 'Auth\RegisterController@sendConfirmMail');
    Route::get('/confirm-registration/{token}', 'Auth\RegisterController@confirmRegistration');
    // product
    Route::post('/get-product', 'StaticController@getProduct');
    // deprecated (delete after merge feature groups)
    Route::post('/get-category-products', 'StaticController@getCategoryProducts');
    // home
    Route::get('/', 'HomeController@index')->name('home');
});

Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function() {
    Route::post('/delete-order', 'UserController@deleteOrder');
    // settings
    Route::get('/settings', 'AdminController@settings')->name('settings');
    Route::post('/settings', 'AdminController@editSettings');
    // user
    Route::get('/users/{slug?}', 'AdminController@users')->name('users');
    Route::post('/delete-user', 'AdminController@deleteUser');
    // offices
    Route::get('/offices', 'AdminController@offices')->name('offices');
    Route::post('/offices', 'AdminController@editOffices');
    Route::post('/delete-office', 'AdminController@deleteOffice');
    // tasting
    Route::get('/tastings/{slug?}', 'AdminController@tastings')->name('tastings');
    Route::post('/tasting', 'AdminController@editTasting');
    Route::post('/tasting-images', 'AdminController@editTastingsImages');
    Route::post('/delete-tasting', 'AdminController@deleteTasting');
    Route::post('/delete-tasting-user', 'AdminController@deleteTastingUser');
    // shops
    Route::get('/shops', 'AdminController@shops')->name('shops');
    Route::post('/shops', 'AdminController@editShops');
    Route::post('/delete-shop', 'AdminController@deleteShop');
    // home page
    Route::get('/', 'AdminController@index');
});
