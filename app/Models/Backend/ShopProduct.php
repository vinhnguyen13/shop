<?php

namespace App\Models\Backend;

use App\Helpers\Grid;
use App\Models\ShopProduct as MainShopProduct;
use DB;

class ShopProduct extends MainShopProduct
{
    public function gridIndex(){
        $query = DB::table('shop_product AS a');
        $grid = new Grid($query, [
            'id',
            'name' => [
                'label' => 'Name',
                'filter' => 'like',
            ],
            'sku',
            'price',
            'quantity',
            'status',
            'created_at',
        ]);
        return $grid;
    }
}
