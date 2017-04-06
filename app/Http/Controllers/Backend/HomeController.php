<?php
/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 4/19/2016
 * Time: 11:27 AM
 */
namespace App\Http\Controllers\Backend;

use App\Models\ShopCustomer;
use App\Models\ShopOrder;
use App\Models\ShopOrderDetail;
use App\Models\ShopOrderProduct;
use App\Models\ShopProduct;
use App\Models\ShopProductDetail;
use App\Services\UploadMedia;
use Illuminate\Http\Request;
use Cache;
use Redirect;

class HomeController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth');
    }

    public function index()
    {
        return view('home.index', ['content' => PHP_EOL . \Illuminate\Foundation\Inspiring::quote() . PHP_EOL]);
    }

    public function demo()
    {
        return view('demo', ['content' => PHP_EOL . \Illuminate\Foundation\Inspiring::quote() . PHP_EOL]);
    }

    public function upload(Request $request, $type)
    {
        $response = app(UploadMedia::class)->upload($request, $type);
        if (!empty($response)) {
            return $response;
        }
        return ['files' => 'upload failed'];
    }

    public function deleteFile(Request $request, $type)
    {
        $response = app(UploadMedia::class)->deleteFile($request, $type);
        if (!empty($response)) {
            return $response;
        }
        return [];
    }

    public function cache(Request $request)
    {
        return view('home.cache');
    }

    public function cacheClear(Request $request)
    {
        $key = $request->get('key');
        if(!empty($key)){
            Cache::forget($key);
        }else{
            Cache::flush();
        }
        return Redirect::route('admin.cache.index');
    }

    public function cleanDB()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');
        ShopProductDetail::query()->update([
            'stock_status_id'=>ShopProductDetail::STOCK_IN_STOCK,
            'stock_in_date'=>null,
            'debt_status'=>ShopProductDetail::DEBT_START,
        ]);
        app(ShopProduct::class)->updateStock();
        ShopOrder::query()->truncate();
        ShopOrderDetail::query()->truncate();
        ShopOrderProduct::query()->truncate();
        ShopCustomer::query()->truncate();

    }

}