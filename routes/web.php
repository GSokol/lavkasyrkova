<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

Route::auth();
Route::get('/logout', 'Auth\LoginController@logout');

Route::as('face.')->group(function() {
    Route::get('/', 'StaticController@index')->name('home');
    // profile
    Route::group(['prefix' => 'profile', 'middleware' => ['auth']], function() {
        Route::get('/', 'UserController@index');
        Route::get('/user', 'UserController@user');
        Route::get('/orders', 'UserController@orders');
        Route::post('/user', 'UserController@editUser');
        Route::post('/checkout-order', 'UserController@checkoutOrder');
        Route::post('/signing-tasting', 'UserController@signingTasting');
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
});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth.admin']], function() {
    // home page
    Route::get('/', 'AdminController@index');
    // categories
    Route::group(['prefix' => 'category'], function () {
        Route::get('/', 'AdminController@categories')->name('categoryList');
        Route::get('/{id}', 'AdminController@category')->name('category');
        Route::post('/{id}', 'AdminController@postCategory')->name('postCategory');
        Route::delete('/delete', 'AdminController@deleteCategory')->name('deleteCategory');
    });
    // seo
    Route::get('seo', 'AdminController@seo');
    Route::post('seo', 'AdminController@editSeo');
    // settings
    Route::get('/settings', 'AdminController@settings');
    Route::post('/settings', 'AdminController@editSettings');
    // product
    Route::get('/products/{slug?}', 'AdminController@products');
    Route::post('/product', 'AdminController@editProduct');
    Route::post('/delete-product', 'AdminController@deleteProduct');
    // user
    Route::get('/users/{slug?}', 'AdminController@users');
    Route::post('/delete-user', 'AdminController@deleteUser');
    // order
    Route::get('/orders', 'AdminController@orders');
    Route::post('/delete-order', 'UserController@deleteOrder');
    // offices
    Route::get('/offices', 'AdminController@offices');
    Route::post('/offices', 'AdminController@editOffices');
    Route::post('/delete-office', 'AdminController@deleteOffice');
    // tasting
    Route::get('/tastings/{slug?}', 'AdminController@tastings');
    Route::post('/tasting', 'AdminController@editTasting');
    Route::post('/tasting-images', 'AdminController@editTastingsImages');
    Route::post('/delete-tasting', 'AdminController@deleteTasting');
    Route::post('/delete-tasting-user', 'AdminController@deleteTastingUser');
    // shops
    Route::get('/shops', 'AdminController@shops');
    Route::post('/shops', 'AdminController@editShops');
    Route::post('/delete-shop', 'AdminController@deleteShop');
});
