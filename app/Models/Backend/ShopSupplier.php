<?php

namespace App\Models\Backend;

use App\Helpers\Grid;
use App\Models\ShopSupplier as MainShopSupplier;
use DB;

class ShopSupplier extends MainShopSupplier
{
    protected $fillable = ['name', 'address', 'country_id', 'city_id', 'district_id',
        'phone', 'fax', 'email', 'payment_method', 'discount_type', 'discount_available', 'type_goods', 'notes', 'order', 'url', 'logo'];

    public function gridIndex(){
        $query = DB::table('shop_supplier AS a');
        $grid = new Grid($query, [
            'id',
            'name' => [
                'filter' => 'like',
            ],
        ]);
        return $grid;
    }
}
