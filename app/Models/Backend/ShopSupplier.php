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
            'phone',
            'consignment_fee',
            'consignment_fee_type' => [
                'format' => function($item){
                    $html = ShopSupplier::consignmentFeeTypeLabel($item->consignment_fee_type);
                    return $html;
                }
            ],
        ]);
        return $grid;
    }
}
