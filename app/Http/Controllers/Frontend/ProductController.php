<?php
/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 4/19/2016
 * Time: 11:27 AM
 */
namespace App\Http\Controllers\Frontend;

use App\Helpers\AppHelper;
use App\Http\Requests\CheckoutRequest;
use App\Models\Backend\ShopManufacturer;
use App\Models\Frontend\ShopCustomer;
use App\Models\Frontend\ShopOrder;
use App\Models\Frontend\ShopProduct;
use App\Models\Frontend\User;
use App\Services\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Input;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    public function index(Request $request, $category=null)
    {
        $products = app(ShopProduct::class)->getList(['category'=>$category, 'limit'=>ShopProduct::PAGINATE]);
        if($request->ajax()) {
            return $this->loadMore($request, $products);
        }
        return view('product.main.index', compact('products'));
    }

    public function store(Request $request, $category=null)
    {
        $products = app(ShopProduct::class)->getList(['category'=>$category, 'limit'=>ShopProduct::PAGINATE]);
        if($request->ajax()) {
            return $this->loadMore($request, $products);
        }
        return view('product.main.index', compact('products'))->with('breadcrumbs', app(AppHelper::class)->getBreadcrumb());
    }

    public function brand(Request $request, $brand=null)
    {
        $products = app(ShopProduct::class)->getList(['brand'=>$brand, 'limit'=>ShopProduct::PAGINATE]);
        if($request->ajax()) {
            return $this->loadMore($request, $products);
        }
        return view('product.main.index', compact('products'))->with('breadcrumbs', app(AppHelper::class)->getBreadcrumb());
    }

    private function loadMore($request, $products){
        if($request->ajax()) {
            $next_page = false;
            if($products->hasMorePages()){
                $next_page = $products->nextPageUrl();
            }
            return [
                'html' => view('product.main.partials.items')->with(compact('products'))->render(),
                'next_page' => $next_page,
            ];
        }
    }

    public function detail(Request $request, $id)
    {
        $size = $request->get('size');
        $product = ShopProduct::find($id);
        $products = app(ShopProduct::class)->getList(['limit'=>30]);
        return view('product.main.detail', compact('product', 'products', 'size'));
    }

    public function cartAdd(Request $request)
    {
        $quantity = $request->get('quantity');
        $size = $request->get('size');
        $product = $request->get('product');
        $productID = !empty($product) ? decrypt($product) : null;
        $detail = $request->get('detail');
        $detailID = !empty($detail) ? decrypt($detail) : null;
        $cart = app(Payment::class)->addCart($productID, $detailID, $size, $quantity);
        $total = !empty($cart) ? count($cart) : 0;
        $html = view('product.main.partials.cart-header', compact('cart'))->render();
        return ['total'=>$total, 'html'=>$html];
    }

    public function cartRemove(Request $request)
    {
        $size = $request->get('size');
        $product = $request->get('product');
        $productID = decrypt($product);
        $cart = app(Payment::class)->removeCart($productID, $size);
        return $cart;
    }

    public function cartUpdate(Request $request)
    {
        $cart = app(Payment::class)->getCart();
        $checkoutInfo = app(Payment::class)->getCheckoutInfo();
        $html = view('product.checkout.partials.products', compact('cart', 'checkoutInfo'))->render();
        return ['html'=>$html];
    }

    public function checkout(Request $request, $step)
    {
        $user = auth()->user();
        $is_seller = !empty($user->is_seller) ? $user->is_seller : 0;
        $nextStep = app(Payment::class)->nextStep($step);
        $view = app(Payment::class)->viewByStep($step);
        $cart = app(Payment::class)->getCart();
        if (!auth()->guest()){
            $stepFirst = app(Payment::class)->isStep($step, 1);
            if($stepFirst){
                return redirect(route('product.checkout', ['step'=>$nextStep]));
            }
        }
        $checkoutInfo = app(Payment::class)->getCheckoutInfo();
        if($request->isMethod('post')){
            $input = \Input::all();
            $checkoutRequest = new CheckoutRequest();
            $rules = $checkoutRequest->rules($step);
            $validator = Validator::make($input, $rules, $checkoutRequest->messages());
            if($validator->fails()) {
                \Session::flash('errors', $validator->errors());
                return Redirect::back();
            }
            /*
             * Login if exist account
             */
            if(!empty($input['password'])){
                app(User::class)->login($input['email'], $input['password']);
            }
            $checkoutInfo = app(Payment::class)->addCheckoutInfo($input);
            if(!empty($nextStep)){
                /*
                 * Redirect next step
                 */
                return redirect(route('product.checkout', ['step'=>$nextStep]));
            }else{
                /*
                 * Order with information all steps
                 */
                unset($checkoutInfo['_token']);
                $return = app(Payment::class)->checkout($checkoutInfo);
                if(!empty($return->id)){
                    return redirect(route('product.payment.success', ['order'=>$return->id]));
                }else{
                    return Redirect::back()->withErrors($return);
                }
            }
        }
        return view('product.checkout.index', compact('cart', 'step', 'is_seller', 'view', 'checkoutInfo'));
    }

    public function checkoutForStaff(Request $request)
    {
        return view('product.checkout.for-staff', compact('cart', 'step', 'is_seller', 'view', 'checkoutInfo'));
    }

    public function order(Request $request)
    {
        if($request->isMethod('post')) {
            $input = \Input::all();
            unset($input['_token']);
            $return = app(Payment::class)->checkout($input);
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
        $orderID = $request->get('order');
        $print = $request->get('print');
        if(!empty($orderID)){
            $order = ShopOrder::find($orderID);
            if(empty($order)){
                return redirect('/');
            }
        }
        if(!empty($print)){
            return view('product.payment.print.success', compact('order'));
        }else{
            return view('product.payment.success', compact('order'));
        }
    }

    public function payFail(Request $request)
    {
        return view('product.payment.fail');
    }

    public function loadCustomers(Request $request)
    {
        $input = $request->get('input');
        $customers = ShopCustomer::query()
            ->where('email', 'like','%'.$input.'%')
            ->orWhere('name', 'like','%'.$input.'%')
            ->orWhere('phone', 'like','%'.$input.'%')
            ->limit(5)
            ->pluck('name', 'id');
        return $customers;
    }

    public function loadCustomer(Request $request)
    {
        $cid = $request->get('cid');
        if(!empty($cid)){
            $customer = ShopCustomer::find($cid);
            return $customer;
        }
    }
}