<?php

namespace App\Models\Backend;

use App\Helpers\Grid;
use App\Models\ShopSupplier as MainShopSupplier;
use DB;

class ShopSupplier extends MainShopSupplier
{
    public function gridIndex(){
        $query = DB::table('shop_supplier AS a');
        $grid = new Grid($query, [
            'id',
            'name' => [
                'filter' => 'like',
            ],
            'code' => [
                'filter' => 'like',
            ],
        ]);
        return $grid;
    }
}
