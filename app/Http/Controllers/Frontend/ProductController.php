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
        $quantity = $request->get('quantity');
        $detailID = $request->get('detail');
        $detailID = decrypt($detailID);
        $cart = app(ShopProduct::class)->addCart($detailID, $quantity);
        $total = !empty($cart) ? count($cart) : 0;
        $html = view('product.partials.cart-header', compact('cart'))->render();
        return ['total'=>$total, 'html'=>$html];
    }

    public function cartRemove(Request $request)
    {
        $detailID = $request->get('detail');
        $detailID = decrypt($detailID);
        $cart = app(ShopProduct::class)->removeCart($detailID);
        return $cart;
    }

    public function cartUpdate(Request $request)
    {
        $cart = app(ShopProduct::class)->getCart();
        $html = view('product.partials.checkout-products', compact('cart'))->render();
        return ['html'=>$html];
    }

    public function checkout(Request $request)
    {
        $cart = app(ShopProduct::class)->getCart();
        return view('product.checkout', compact('cart'));
    }

    public function order(Request $request)
    {
        if($request->isMethod('post')) {
            $input = \Input::all();
            unset($input['_token']);
            $return = app(ShopOrder::class)->processingSaveOrder([], $input);
            if(!empty($return->id)){
                return ['code'=>0, 'message'=>'', 'return'=>$return];
            }else{
                return ['code'=>400, 'message'=>$return];
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