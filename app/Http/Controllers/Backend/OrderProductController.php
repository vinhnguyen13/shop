<?php
/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 4/19/2016
 * Time: 11:27 AM
 */
namespace App\Http\Controllers\Backend;

use App\Models\Backend\ShopOrder;
use App\Models\Backend\ShopOrderProduct;
use App\Models\Backend\ShopProduct;
use Illuminate\Http\Request;

class OrderProductController extends Controller
{
    public function index(Request $request)
    {
        $grid = app(ShopOrderProduct::class)->gridIndex();
        if ($request->ajax()) {
            return $grid->table();
        }else{
            return view('order-product.index', compact('grid'));
        }
    }

}