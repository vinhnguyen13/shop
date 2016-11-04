<?php

namespace App\Models\Backend;

use App\Models\ShopCategory as MainShopCategory;
use DB;
use App\Helpers\Grid;

class ShopCategory extends MainShopCategory
{
    public function gridIndex(){
        $query = DB::table('shop_category AS a');
        $grid = new Grid($query, [
            'id',
            'name' => [
                'label' => 'Name',
                'filter' => 'like',
            ],
            'status' => [
            ],
            'created_at'=> [
            ],
        ]);
        return $grid;
    }
}
