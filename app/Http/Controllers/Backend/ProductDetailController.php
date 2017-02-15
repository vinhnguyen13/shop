<?php
/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 4/19/2016
 * Time: 11:27 AM
 */
namespace App\Http\Controllers\Backend;

use App\Models\Backend\ShopProductDetail;
use Illuminate\Http\Request;
use Input;
use Illuminate\Support\Facades\Redirect;

class ProductDetailController extends Controller
{
    public function index(Request $request)
    {
        $grid = app(ShopProductDetail::class)->gridIndex();
        if ($request->ajax()) {
            return $grid->table();
        }else{
            return view('product-detail.index', compact('grid'));
        }
    }
}