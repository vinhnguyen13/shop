<?php

namespace App\Models\Backend;

use App\Helpers\Grid;
use App\Models\ShopCustomer as MainShopCustomer;
use DB;

class ShopCustomer extends MainShopCustomer
{
    public function gridIndex(){
        $query = DB::table('shop_customer AS a');
        $grid = new Grid($query, [
            'id',
            'firstname',
            'lastname',
            'phone',
            'fax',
            'email',
            'created_at',
        ]);
        return $grid;
    }
}
