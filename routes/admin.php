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
        /*
         * Categories
         */
        Route::get('/category', ['uses' => 'CategoryController@index', 'as'=>'admin.category.index']);
        Route::get('/category/create', ['uses' => 'CategoryController@create', 'as'=>'admin.category.create']);
        Route::post('/category/store', ['uses' => 'CategoryController@store', 'as'=>'admin.category.store']);
        Route::get('/category/edit/{id}', ['uses' => 'CategoryController@edit', 'as'=>'admin.category.edit']);
        Route::get('/category/show/{id}', ['uses' => 'CategoryController@show', 'as'=>'admin.category.show']);
        /*
         * Products
         */
        Route::get('/product', ['uses' => 'ProductController@index', 'as'=>'admin.product.index']);
        Route::get('/product/create', ['uses' => 'ProductController@create', 'as'=>'admin.product.create']);
        Route::post('/product/store', ['uses' => 'ProductController@store', 'as'=>'admin.product.store']);
        Route::get('/product/edit/{id}', ['uses' => 'ProductController@edit', 'as'=>'admin.product.edit']);
        Route::get('/product/show/{id}', ['uses' => 'ProductController@show', 'as'=>'admin.product.show']);
        /*
         * Manufacturers
         */
        Route::get('/manufacturer', ['uses' => 'ManufacturerController@index', 'as'=>'admin.manufacturer.index']);
        Route::get('/manufacturer/create', ['uses' => 'ManufacturerController@create', 'as'=>'admin.manufacturer.create']);
        Route::post('/manufacturer/store', ['uses' => 'ManufacturerController@store', 'as'=>'admin.manufacturer.store']);
        Route::get('/manufacturer/edit/{id}', ['uses' => 'ManufacturerController@edit', 'as'=>'admin.manufacturer.edit']);
        Route::get('/manufacturer/show/{id}', ['uses' => 'ManufacturerController@show', 'as'=>'admin.manufacturer.show']);
        /*
         * Shipper
         */
        Route::get('/shipper', ['uses' => 'ShipperController@index', 'as'=>'admin.shipper.index']);
        Route::get('/shipper/create', ['uses' => 'ShipperController@create', 'as'=>'admin.shipper.create']);
        Route::post('/shipper/store', ['uses' => 'ShipperController@store', 'as'=>'admin.shipper.store']);
        Route::get('/shipper/edit/{id}', ['uses' => 'ShipperController@edit', 'as'=>'admin.shipper.edit']);
        Route::get('/shipper/show/{id}', ['uses' => 'ShipperController@show', 'as'=>'admin.shipper.show']);
        Route::get('/shipper/transport', ['uses' => 'ShipperController@transport', 'as'=>'admin.shipper.transport']);
        /*
         * Supplier
         */
        Route::get('/supplier', ['uses' => 'SupplierController@index', 'as'=>'admin.supplier.index']);
        Route::get('/supplier/create', ['uses' => 'SupplierController@create', 'as'=>'admin.supplier.create']);
        Route::post('/supplier/store', ['uses' => 'SupplierController@store', 'as'=>'admin.supplier.store']);
        Route::get('/supplier/edit/{id}', ['uses' => 'SupplierController@edit', 'as'=>'admin.supplier.edit']);
        Route::get('/supplier/show/{id}', ['uses' => 'SupplierController@show', 'as'=>'admin.supplier.show']);
        /*
         * Customer
         */
        Route::get('/customer', ['uses' => 'CustomerController@index', 'as'=>'admin.customer.index']);
        Route::get('/customer/create', ['uses' => 'CustomerController@create', 'as'=>'admin.customer.create']);
        Route::post('/customer/store', ['uses' => 'CustomerController@store', 'as'=>'admin.customer.store']);
        Route::get('/customer/edit/{id}', ['uses' => 'CustomerController@edit', 'as'=>'admin.customer.edit']);
        Route::get('/customer/show/{id}', ['uses' => 'CustomerController@show', 'as'=>'admin.customer.show']);
        /*
         * Order
         */
        Route::get('/order', ['uses' => 'OrderController@index', 'as'=>'admin.order.index']);
        Route::get('/order/create', ['uses' => 'OrderController@create', 'as'=>'admin.order.create']);
        Route::post('/order/store', ['uses' => 'OrderController@store', 'as'=>'admin.order.store']);
        Route::get('/order/edit/{id}', ['uses' => 'OrderController@edit', 'as'=>'admin.order.edit']);
        Route::get('/order/show/{id}', ['uses' => 'OrderController@show', 'as'=>'admin.order.show']);
        /* Coupon Event routing*/
        Route::get('/coupon-event', ['uses' => 'CouponEventController@index', 'as' => 'admin.cpevent.index']);
        Route::get('/coupon-event/create', ['uses' => 'CouponEventController@create', 'as' => 'admin.cpevent.create']);
        Route::get('/coupon-event/edit/{id}', ['uses' => 'CouponEventController@edit', 'as' => 'admin.cpevent.edit']);
        Route::get('/coupon-event/delete/{id}', ['uses' => 'CouponEventController@destroy', 'as' => 'admin.cpevent.delete']);
        Route::get('/coupon-event/show/{id}', ['uses' => 'CouponEventController@show', 'as' => 'admin.cpevent.show']);
        Route::post('/coupon-event/create', ['uses' => 'CouponEventController@store', 'as' => 'admin.cpevent.store']);
        Route::patch('/coupon-event/edit/{id}', ['uses' => 'CouponEventController@update', 'as' => 'admin.cpevent.update']);

        /* Coupon Code routing*/
        Route::get('/coupon-code', ['uses' => 'CouponCodeController@index', 'as' => 'admin.cpcode.index']);
        Route::get('/coupon-code/create', ['uses' => 'CouponCodeController@create', 'as' => 'admin.cpcode.create']);
        Route::get('/coupon-code/create-random', ['uses' => 'CouponCodeController@createRandom', 'as' => 'admin.cpcode.create-random']);
        Route::get('/coupon-code/edit/{id}', ['uses' => 'CouponCodeController@edit', 'as' => 'admin.cpcode.edit']);
        Route::get('/coupon-code/delete/{id}', ['uses' => 'CouponCodeController@destroy', 'as' => 'admin.cpcode.delete']);
        Route::get('/coupon-code/show/{id}', ['uses' => 'CouponCodeController@show', 'as' => 'admin.cpcode.show']);
        Route::post('/coupon-code/create', ['uses' => 'CouponCodeController@store', 'as' => 'admin.cpcode.store']);
        Route::post('/coupon-code/create-random', ['uses' => 'CouponCodeController@storeRandom', 'as' => 'admin.cpcode.store-random']);
        Route::patch('/coupon-code/edit/{id}', ['uses' => 'CouponCodeController@update', 'as' => 'admin.cpcode.update']);
        Route::get('/coupon-code/donate', ['uses' => 'CouponCodeController@donate', 'as' => 'admin.cpcode.donate']);
        Route::post('/coupon-code/donate', ['uses' => 'CouponCodeController@donate', 'as' => 'admin.cpcode.donate']);
    });
});
