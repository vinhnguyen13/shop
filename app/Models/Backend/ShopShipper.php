<?php

namespace App\Models\Backend;

use App\Helpers\Grid;
use App\Models\ShopShipper as Model;
use DB;

class ShopShipper extends Model
{

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
