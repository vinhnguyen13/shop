<?php
/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 4/19/2016
 * Time: 11:27 AM
 */
namespace App\Http\Controllers\Frontend;

use App\Models\Frontend\ShopProduct;

class HomeController extends Controller
{
    public function index()
    {
        $products = app(ShopProduct::class)->getList(['limit'=>30]);
        return view('home', compact('products'));
    }
}