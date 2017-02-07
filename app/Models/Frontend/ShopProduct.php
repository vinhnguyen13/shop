<?php

namespace App\Models\Frontend;

use App\Helpers\AppHelper;
use App\Helpers\Grid;
use App\Models\Backend\ShopManufacturer;
use App\Models\Backend\ShopCategory;
use App\Models\ShopProduct as MainShopProduct;
use DB;
use Session;

class ShopProduct extends MainShopProduct
{
    const CHECKOUT_PRODUCTS = 'products';
    const CHECKOUT_SHIPPING = 'shipping';
    const CHECKOUT_BILLING = 'billing';
    const CHECKOUT_PAYMENT = 'payment';
    const SPLIT_PRODUCT_SIZE = '_GLAB_';

    public function getList($params = array()){
        $query = ShopProduct::from('shop_product AS a');
        $query->where(['status'=>1]);
        app(AppHelper::class)->setBreadcrumb(['/'=>'Home']);
        if(!empty($params['category'])){
            $category = ShopCategory::query()->where(['slug'=>$params['category']])->first();
            if(!empty($category)){
                $query->join('shop_product_category AS b', function ($join) use ($category){
                    $join->on('a.id', '=', 'b.product_id')->where(['b.category_id'=>$category->id]);
                });
                app(AppHelper::class)->setBreadcrumb([route('product.category', ['category'=>str_slug($category->slug)])=>$category->name]);
            }
        }
        if(!empty($params['brand'])){
            $manufacturer = ShopManufacturer::query()->where(['slug'=>$params['brand']])->first();
            if(!empty($manufacturer)){
                $query->where(['manufacturer_id'=>$manufacturer->id]);
                app(AppHelper::class)->setBreadcrumb([route('product.brand', ['brand'=>str_slug($manufacturer->slug)])=>$manufacturer->name]);
            }
        }
        $products = $query->orderBy('updated_at', 'DESC')->paginate($params['limit'], ['*'], 'page');
        return $products;
    }

    public function addCart($pid, $size, $quantity){
        $item = [
            'product_id'=>$pid,
            'size'=>$size,
            'quantity'=>$quantity,
        ];
        $cart = [];
        if (Session::has('cart')) {
            $cart = Session::get('cart');
        }
        $key = $pid.self::SPLIT_PRODUCT_SIZE.$size;
        if(!empty($cart[$key]) && $cart[$key]['size'] == $size){
            $cart[$key]['quantity'] += $quantity;
        }else{
            $cart[$key] = $item;
        }
        Session::put('cart', $cart);
        return $cart;

    }

    public function getCart(){
        if (Session::has('cart')) {
            $cart = Session::get('cart');
            return $cart;
        }
        return false;
    }

    public function removeCart($pid, $size){
        if (Session::has('cart')) {
            $cart = Session::get('cart');
            $key = $pid.self::SPLIT_PRODUCT_SIZE.$size;
            if(!empty($cart[$key])){
                unset($cart[$key]);
                Session::put('cart', $cart);
                return $cart;
            }
        }
       return false;
    }

    public function removeCartAll(){
        if (Session::has('cart')) {
            Session::remove('cart');
        }
        return false;
    }

    public function checkout(){

    }
}
