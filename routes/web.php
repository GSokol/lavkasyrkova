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
Route::get('/send-confirm-mail', 'Auth\RegisterController@sendConfirmMail');
Route::get('/confirm-registration/{token}', 'Auth\RegisterController@confirmRegistration');

Route::get('/admin', 'AdminController@index');
Route::get('/profile', 'UserController@index');

Route::get('/admin/seo', 'AdminController@seo');
Route::post('/admin/seo', 'AdminController@editSeo');

Route::get('/admin/users/{slug?}', 'AdminController@users');
Route::get('/profile/user', 'UserController@user');
Route::post('/profile/user', 'UserController@editUser');
Route::post('/admin/delete-user', 'AdminController@deleteUser');
Route::post('/profile/signing-tasting', 'UserController@signingTasting');

Route::get('/profile/orders', 'UserController@orders');
Route::get('/admin/orders', 'AdminController@orders');

Route::post('/basket', 'BasketController@editBasket');
Route::post('/empty-basket', 'BasketController@emptyBasket');
Route::post('/checkout-order', 'BasketController@checkoutOrder');

Route::post('/profile/checkout-order', 'UserController@checkoutOrder');
Route::post('/admin/delete-order', 'UserController@deleteOrder');

Route::get('/admin/products/{slug?}', 'AdminController@products');
Route::post('/admin/product', 'AdminController@editProduct');
Route::post('/admin/delete-product', 'AdminController@deleteProduct');

Route::get('/admin/tastings/{slug?}', 'AdminController@tastings');
Route::post('/admin/tasting', 'AdminController@editTasting');
Route::post('/admin/tasting-images', 'AdminController@editTastingsImages');
Route::post('/admin/delete-tasting', 'AdminController@deleteTasting');
Route::post('/admin/delete-tasting-user', 'AdminController@deleteTastingUser');

Route::get('/admin/settings', 'AdminController@settings');
Route::post('/admin/settings', 'AdminController@editSettings');

Route::get('/admin/offices', 'AdminController@offices');
Route::post('/admin/offices', 'AdminController@editOffices');
Route::post('/admin/delete-office', 'AdminController@deleteOffice');

Route::get('/admin/shops', 'AdminController@shops');
Route::post('/admin/shops', 'AdminController@editShops');
Route::post('/admin/delete-shop', 'AdminController@deleteShop');

Route::get('/', 'StaticController@index');
Route::post('/get-category-products', 'StaticController@getCategoryProducts');
Route::post('/get-product', 'StaticController@getProduct');