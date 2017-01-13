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
use App\Models\Frontend\ShopOrder;
use App\Models\Frontend\ShopProduct;
use Illuminate\Http\Request;
use Input;
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
        $products = app(ShopProduct::class)->getList(['brand'=>$brand, 'limit'=>30]);
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

    public function cartAdd(Request $request)
    {
        $data = $request->get('data');
        $pid = decrypt($data);
        $quantity = $request->get('quantity');
        $size = $request->get('size');
        $cart = app(ShopProduct::class)->addCart($pid, $size, $quantity);
        return view('product.partials.cart-header', compact('cart'));
    }

    public function cartRemove(Request $request)
    {
        $data = $request->get('data');
        $pid = decrypt($data);
        $cart = app(ShopProduct::class)->removeCart($pid);
        return $cart;
    }

    public function checkout(Request $request, $step)
    {
        $cart = app(ShopProduct::class)->getCart();
        return view('product.checkout', compact('cart', 'step'));
    }

    public function order(Request $request)
    {
        if($request->isMethod('post')) {
            $input = \Input::all();
            unset($input['_token']);
            $return = app(ShopOrder::class)->processingSaveOrder([], $input);
            if(!empty($return)){
                app(ShopProduct::class)->removeCartAll();
                return ['code'=>0, 'message'=>'', 'return'=>$return];
            }
        }
        return ['code'=>2, 'message'=>''];
    }

    public function paySuccess(Request $request)
    {
        $order = $request->get('order');
        if(!empty($order)){
        }
        return view('product.payment-success');
    }

    public function payFail(Request $request)
    {
        return view('product.payment-fail');
    }
}