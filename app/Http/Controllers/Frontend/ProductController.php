<?php
/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 4/19/2016
 * Time: 11:27 AM
 */
namespace App\Http\Controllers\Frontend;

use App\Models\Frontend\ShopProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    public function index(Request $request, $category=null)
    {
        $products = app(ShopProduct::class)->getList(['category'=>$category, 'limit'=>30]);
        return view('product.index', compact('products'));
    }

    public function store(Request $request, $category=null)
    {
        $products = app(ShopProduct::class)->getList(['category'=>$category, 'limit'=>30]);
        return view('product.index', compact('products'));
    }

    public function brand(Request $request, $brand=null)
    {
        $products = app(ShopProduct::class)->getList(['brand'=>$brand, 'limit'=>30]);
        return view('product.index', compact('products'));
    }
}