<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:api');
Route::group(['prefix' => 'api', 'middleware' => ['api'], 'module' => 'Rest', 'namespace' => 'App\Http\Controllers\Rest'], function () {
    Route::get('/user', ['uses' => 'UserController@index', 'as'=>'user_index', 'before' => 'throttle:60, 1']);/*60 requests in 1 minutes.*/
    Route::post('/product/search', ['uses' => 'ProductController@search', 'as'=>'api.product.search']);
    Route::post('/product/get', ['uses' => 'ProductController@get', 'as'=>'api.product.get']);
    Route::post('/customer/search', ['uses' => 'CustomerController@search', 'as'=>'api.customer.search']);
    Route::post('/customer/get', ['uses' => 'CustomerController@get', 'as'=>'api.customer.get']);
});
