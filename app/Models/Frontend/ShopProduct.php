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

    public function addCart($detailID, $quantity){
        $item = [
            'detailID'=>$detailID,
            'quantity'=>$quantity,
        ];
        $cart = [];
        if (Session::has('cart')) {
            $cart = Session::get('cart');
        }
        if(!empty($cart[$detailID]) && $cart[$detailID]['detailID'] == $detailID){
            $cart[$detailID]['quantity'] = $quantity;
        }else{
            $cart[$detailID] = $item;
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

    public function removeCart($detailID){
        if (Session::has('cart')) {
            $cart = Session::get('cart');
            if(!empty($cart[$detailID])){
                unset($cart[$detailID]);
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
