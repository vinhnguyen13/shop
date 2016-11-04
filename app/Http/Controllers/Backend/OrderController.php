<?php
/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 4/19/2016
 * Time: 11:27 AM
 */
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\ShopOrder;
use App\Models\Backend\ShopProduct;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $grid = app(ShopOrder::class)->gridIndex();
        if ($request->ajax()) {
            return $grid->table();
        }else{
            return view('order.index', compact('grid'));
        }
    }

}