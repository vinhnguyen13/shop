<?php

namespace App\Models\Backend;

use App\Helpers\Grid;
use App\Models\ShopOrder as MainShopOrder;
use DB;

class ShopOrder extends MainShopOrder
{
    public function grid(){
        $query = DB::table('shop_order AS a');
        $grid = new Grid($query, [
            'id',
            'invoice_no',
            'invoice_prefix',
            'customer_id' => [
                'label'=>'Customer',
                'filter' => 'like',
            ],
            'order_status_id',
            'total',
            'created_at',
            'updated_at',
        ]);
        return $grid;
    }
}
