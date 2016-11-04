<?php

namespace App\Models\Backend;

use App\Helpers\Grid;
use App\Models\ShopManufacturer as MainShopManufacturer;
use DB;

class ShopManufacturer extends MainShopManufacturer
{
    public function gridIndex(){
        $query = DB::table('shop_manufacturer AS a');
        $grid = new Grid($query, [
            'id',
            'name',
        ]);
        return $grid;
    }
}
