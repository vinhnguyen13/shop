<?php

namespace App\Models\Frontend;

use App\Helpers\Grid;
use App\Models\ShopProduct as MainShopProduct;
use DB;

class ShopProduct extends MainShopProduct
{
    public function getList($where, $limit){
        $products = self::query()->where($where)->limit($limit)->orderBy('updated_at', 'DESC')->get();
        return $products;
    }
}
