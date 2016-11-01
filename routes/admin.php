<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\App;

Route::group(['prefix' => 'admin', 'middleware' => ['web'], 'module' => 'Backend', 'namespace' => 'App\Http\Controllers\Backend'], function () {
    Route::get('/demo', ['uses' => 'HomeController@demo', 'as'=>'admin.home.demo']);
    Route::get('/home-demo', ['uses' => 'HomeController@demo', 'as'=>'admin.home.demo'])->middleware('can:view');
    /**
     * Route must login
     */
    Route::group(['middleware' => ['auth', 'can:isAdmin']], function () {
        /*
         * Default
         */
        Route::get('/', ['uses' => 'HomeController@index', 'as'=>'admin.home.index'])->middleware(['auth']);
        /*
                 * User
                 */
        Route::get('/user', ['uses' => 'UserController@index', 'as'=>'admin.user.index']);
        Route::get('/user/create', ['uses' => 'UserController@create', 'as'=>'admin.user.create']);
        Route::post('/user/store', ['uses' => 'UserController@store', 'as'=>'admin.user.store']);
        Route::get('/user/edit/{id}', ['uses' => 'UserController@edit', 'as'=>'admin.user.edit'])/*->middleware('can:update,App\Modules\Backend\Models\User')*/;
        Route::get('/user/delete/{id}', ['uses' => 'UserController@delete', 'as'=>'admin.user.delete']);
        Route::get('/user/show/{id}', ['uses' => 'UserController@show', 'as'=>'admin.user.show']);
        Route::delete('/user/delete-file', ['uses' => 'UserController@deleteFile', 'as' => 'admin.user.deleteFile']);
        Route::post('/user/upload', ['uses' => 'UserController@uploadAvatar', 'as' => 'admin.user.upload']);
        Route::delete('/user/delete-temp-file', ['uses' => 'UserController@deleteTempFile', 'as' => 'admin.user.deleteTempFile']);
    });
});
