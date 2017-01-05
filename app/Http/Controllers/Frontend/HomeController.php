<?php
/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 4/19/2016
 * Time: 11:27 AM
 */
namespace App\Http\Controllers\Frontend;

use App\Models\Frontend\ShopProduct;
use App\Models\SysDistrict;
use App\Models\SysStreet;
use App\Models\SysWard;

class HomeController extends Controller
{
    public function index()
    {
        $products = app(ShopProduct::class)->getList(['limit'=>30]);
        return view('home', compact('products'));
    }

    public function location()
    {
        $id = request('id');
        $child = request('child');
        if(!empty($child)){
            switch($child){
                case 'district';
                    $data = SysDistrict::query()->select([\DB::raw('CONCAT(pre, " ", name) AS name'), 'id'])->where(['city_id'=>$id])->orderBy('id')->pluck('name', 'id');
                    return $data;
                    break;
                case 'ward';
                    $data = SysWard::query()->select([\DB::raw('CONCAT(pre, " ", name) AS name'), 'id'])->where(['district_id'=>$id])->orderBy('id')->pluck('name', 'id');
                    return $data;
                    break;
            }
        }
        return false;
    }
}