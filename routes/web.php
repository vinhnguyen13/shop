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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::group(['middleware' => ['web'], 'module' => 'Frontend', 'namespace' => 'App\Http\Controllers\Frontend'], function () use ($locale, $langs) {
    /*
     * User authencation
     */
    Route::get('/login', ['uses' => '\App\Http\Controllers\Auth\LoginController@showLoginForm', 'as' => 'login']);
    Route::post('/login', ['uses' => '\App\Http\Controllers\Auth\LoginController@login', 'as' => 'login']);
    Route::get('/logout', ['uses' => '\App\Http\Controllers\Auth\AuthController@logout', 'as' => 'logout']);
    Route::get('/signup', ['uses' => '\App\Http\Controllers\Auth\RegisterController@showRegistrationForm', 'as' => 'register']);
    Route::post('/signup', ['uses' => '\App\Http\Controllers\Auth\RegisterController@register', 'as' => 'register.store']);
    Route::get('/password/forgot', ['uses' => '\App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm', 'as' => 'password.form']);
    Route::post('/password/email', ['uses' => '\App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail', 'as' => 'password.reset']);
    Route::get('/password/reset/{token}', ['uses' => '\App\Http\Controllers\Auth\PasswordController@showResetForm', 'as' => 'password.form']);
    Route::post('/password/reset', ['uses' => '\App\Http\Controllers\Auth\PasswordController@reset', 'as' => 'password.form']);
    Route::get('/user/confirm-login/{id}/{code}', ['uses' => 'UserController@confirmLogin', 'as' => 'user.confirmLogin']);
    /*
     *  Socialite authencation
     */
    Route::get('/login/redirect/{provider}', ['uses' => 'Auth\AuthController@getSocialAuth', 'as' => 'auth.getSocialAuth']);
    Route::get('/login/callback/{provider}', ['uses' => 'Auth\AuthController@getSocialAuthCallback', 'as' => 'auth.getSocialAuthCallback']);
});