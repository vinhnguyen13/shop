<?php

namespace App\Models\Frontend;

use App\Models\Traits\HasValidator;
use App\Models\ShopProductDetail as Model;

class ShopProductDetail extends Model
{

    public function findProductByStaff($data){
        extract($data);
        $query = ShopProductDetail::query()
            ->join('shop_product', function($query) use ($manufacturer, $size, $color) {
                //link customer to their orders
                $query->on('shop_product_detail.product_id', '=', 'shop_product.id');
                //consider only enabled orders
                if(!empty($manufacturer)) {
                    $query->where('shop_product.manufacturer_id', '=', $manufacturer);
                }
                if(!empty($size)){
                    $query->where(['shop_product_detail.size'=>$size]);
                }
                if(!empty($color)){
                    $query->where(['shop_product_detail.color'=>$color]);
                }
                //consider only orders where status != 0
            })
            ->where(['shop_product_detail.stock_status_id' => ShopProductDetail::STOCK_IN_STOCK]);
        if(!empty($from_price) || !empty($to_price)){
            $query->whereBetween('price', [$from_price, $to_price]);
        }
        if(!empty($word)){
            $query->where(function($query) use ($word){
                $query->where('name', 'like', '%'.$word.'%');
                $query->orWhere('shop_product.color', 'like', '%'.$word.'%');
                $query->orWhere('shop_product.sku_producer', 'like', '%'.$word.'%');
            });
        }
        $details = $query->groupBy('shop_product.id')->paginate(20);
        return $details;
    }
}
