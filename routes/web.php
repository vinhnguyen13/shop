<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
$locale = Config::get('app.locale');
$langs = Config::get('app.alt_langs');

Route::group(['middleware' => ['web'], 'module' => 'Frontend', 'namespace' => 'App\Http\Controllers\Frontend'], function () use ($locale, $langs) {
    Route::get('/', 'HomeController@index')->name('home');
    /*
     * User authencation
     */
    Route::get('/login', ['uses' => '\App\Http\Controllers\Frontend\Auth\LoginController@showLoginForm', 'as' => 'login']);
    Route::post('/login', ['uses' => '\App\Http\Controllers\Frontend\Auth\LoginController@login', 'as' => 'login']);
    Route::any('/logout', ['uses' => '\App\Http\Controllers\Frontend\Auth\AuthController@logout', 'as' => 'logout']);
    Route::get('/register', ['uses' => '\App\Http\Controllers\Frontend\Auth\RegisterController@showRegistrationForm', 'as' => 'register']);
    Route::post('/register', ['uses' => '\App\Http\Controllers\Frontend\Auth\RegisterController@register', 'as' => 'register.store']);
    Route::get('/password/forgot', ['uses' => '\App\Http\Controllers\Frontend\Auth\ForgotPasswordController@showLinkRequestForm', 'as' => 'password.form']);
    Route::post('/password/email', ['uses' => '\App\Http\Controllers\Frontend\Auth\ForgotPasswordController@sendResetLinkEmail', 'as' => 'password.sendResetLinkEmail']);
    Route::get('/password/reset/{token}', ['uses' => '\App\Http\Controllers\Frontend\Auth\ResetPasswordController@showResetForm', 'as' => 'password.showResetForm']);
    Route::post('/password/reset', ['uses' => '\App\Http\Controllers\Frontend\Auth\ResetPasswordController@reset', 'as' => 'password.reset']);
    Route::get('/user/confirm-login/{id}/{code}', ['uses' => 'UserController@confirmLogin', 'as' => 'user.confirmLogin']);
    /*
     *  Socialite authencation
     */
    Route::get('/login/redirect/{provider}', ['uses' => '\App\Http\Controllers\Auth\AuthController@getSocialAuth', 'as' => 'auth.getSocialAuth']);
    Route::get('/login/callback/{provider}', ['uses' => '\App\Http\Controllers\Auth\AuthController@getSocialAuthCallback', 'as' => 'auth.getSocialAuthCallback']);
    /*
     * Product
     */
    Route::get('/product', ['uses' => 'ProductController@index'])->name('product.index');
    Route::get('/product/store/{category}', ['uses' => 'ProductController@store'])->name('product.category');
    Route::get('/product/search', ['uses' => 'ProductController@search'])->name('product.search');
    Route::get('/product/brand/{brand}', ['uses' => 'ProductController@brand'])->name('product.brand');
    Route::get('/product/detail/{id}-{slug}', ['uses' => 'ProductController@detail'])->name('product.detail');
    Route::post('/product/cart/add', ['uses' => 'ProductController@cartAdd'])->name('product.cart.add');
    Route::post('/product/cart/remove', ['uses' => 'ProductController@cartRemove'])->name('product.cart.remove');
    Route::get('/product/cart/update', ['uses' => 'ProductController@cartUpdate'])->name('product.cart.update');
    Route::get('/product/checkout/{step}', ['uses' => 'ProductController@checkout'])->name('product.checkout');
    Route::post('/product/checkout/{step}', ['uses' => 'ProductController@checkout'])->name('product.checkout');
    Route::get('/product/checkout-for-staff', ['uses' => 'ProductController@checkoutForStaff'])->name('product.checkout.forStaff');
    Route::post('/product/checkout-for-staff', ['uses' => 'ProductController@checkoutForStaff'])->name('product.checkout.forStaff');
    Route::post('/product/order', ['uses' => 'ProductController@order'])->name('product.order');
    Route::get('/product/payment/success', ['uses' => 'ProductController@paySuccess'])->name('product.payment.success');
    Route::get('/product/payment/fail', ['uses' => 'ProductController@payFail'])->name('product.payment.fail');
    Route::post('/product/load-customers', ['uses' => 'ProductController@loadCustomers'])->name('product.loadCustomers');
    Route::post('/product/load-customer', ['uses' => 'ProductController@loadCustomer'])->name('product.loadCustomer');
    /*
     * Location
     */
    Route::post('/location', ['uses' => 'HomeController@location'])->name('home.location');
    /*
     * Static page
     */
    Route::get('/about', ['uses' => 'PageController@about'])->name('page.about');
    Route::get('/scanner-barcode', ['uses' => 'PageController@scannerBarcode'])->name('page.scanner-barcode');
    Route::get('/instagram', ['uses' => 'PageController@instagram'])->name('page.instagram');
});