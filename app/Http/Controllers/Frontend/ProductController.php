<?php
/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 4/19/2016
 * Time: 11:27 AM
 */
namespace App\Http\Controllers\Frontend;

use App\Helpers\AppHelper;
use App\Models\Backend\ShopManufacturer;
use App\Models\Frontend\ShopProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    public function index(Request $request, $category=null)
    {
        $products = app(ShopProduct::class)->getList(['category'=>$category, 'limit'=>30]);
        if($request->ajax()) {
            return $this->loadMore($request, $products);
        }
        return view('product.index', compact('products'));
    }

    public function store(Request $request, $category=null)
    {
        $products = app(ShopProduct::class)->getList(['category'=>$category, 'limit'=>30]);
        if($request->ajax()) {
            return $this->loadMore($request, $products);
        }
        return view('product.index', compact('products'))->with('breadcrumbs', app(AppHelper::class)->getBreadcrumb());
    }

    public function brand(Request $request, $brand=null)
    {
        $products = app(ShopProduct::class)->getList(['brand'=>$brand, 'limit'=>3]);
        if($request->ajax()) {
            return $this->loadMore($request, $products);
        }
        return view('product.index', compact('products'))->with('breadcrumbs', app(AppHelper::class)->getBreadcrumb());
    }

    private function loadMore($request, $products){
        if($request->ajax()) {
            $next_page = false;
            if($products->hasMorePages()){
                $next_page = $products->nextPageUrl();
            }
            return [
                'html' => view('product.partials.items')->with(compact('products'))->render(),
                'next_page' => $next_page,
            ];
        }
    }

    public function detail(Request $request, $id)
    {
        $product = ShopProduct::find($id);
        $products = app(ShopProduct::class)->getList(['limit'=>30]);
        return view('product.detail', compact('product', 'products'));
    }
}