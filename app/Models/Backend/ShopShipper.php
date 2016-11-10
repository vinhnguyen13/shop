<?php

namespace App\Models\Backend;

use App\Helpers\Grid;
use App\Models\ShopShipper as MainShopShipper;
use DB;

class ShopShipper extends MainShopShipper
{
    protected $fillable = ['firstname', 'lastname', 'phone', 'fax', 'email', 'company', 'address_1', 'address_2', 'country_id', 'city_id', 'district_id'];

    public function gridIndex(){
        $query = DB::table('shop_shipper AS a');
        $grid = new Grid($query, [
            'id',
            'firstname' => [
                'filter' => 'like',
            ],
            'lastname' => [
                'filter' => 'like',
            ],
            'company' => [
                'filter' => 'like',
            ],
        ]);
        return $grid;
    }
}
