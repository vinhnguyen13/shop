<?php

namespace App\Models\Frontend;

use App\Helpers\Grid;
use App\Models\ShopProduct as MainShopProduct;
use DB;

class ShopProduct extends MainShopProduct
{
    public function getList(){
        $products = self::query()->get();
        return $products;
    }

}
