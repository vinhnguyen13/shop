<?php
/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 4/19/2016
 * Time: 11:27 AM
 */
namespace App\Http\Controllers\Rest;

use App\Models\Frontend\ShopProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Input;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{

    public function search(Request $request)
    {
        $input = $request->get('input');
        $products = ShopProduct::query()
            ->where('sku_producer', 'like','%'.$input.'%')
            ->orWhere('name', 'like','%'.$input.'%')
            ->orWhere('color', 'like','%'.$input.'%')
            ->limit(5)
            ->pluck('name', 'id');
        return $products;
    }

    public function get(Request $request)
    {
        $cid = $request->get('pid');
        if(!empty($cid)){
            $customer = ShopProduct::find($cid);
            return $customer;
        }
    }

}