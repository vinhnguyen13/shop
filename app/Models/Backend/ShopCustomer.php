<?php

namespace App\Models\Backend;

use App\Helpers\Grid;
use App\Models\ShopCustomer as Model;
use App\Models\Traits\Location;
use DB;

class ShopCustomer extends Model
{
    public function gridIndex(){
        $query = DB::table('shop_customer AS a');
        $grid = new Grid($query, [
            'id',
            'name',
            'phone',
            'email',
            'location'=>[
                'custom' => true,
                'label'=>'Address',
                'format' => function($item){
                    $record = ShopCustomer::find($item->id);
                    $html = $record->locationToText();
                    return $html;
                },
            ],
            'created_at',
        ]);
        $grid->removeActionColumn();
        return $grid;
    }
}
