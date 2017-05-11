<?php

namespace App\Models\Backend;

use App\Models\SysCity;
use App\Models\ShopShipFee as Model;
use DB;
use App\Helpers\Grid;

class ShopShipFee extends Model
{
    public function gridIndex(){
        $query = DB::table('shop_ship_fee AS a');
        $grid = new Grid($query, [
            'id',
            'city_id' => [
                'label' => 'City',
                'format' => function($item){
                    $cityName = '';
                    if($item->city_id){
                        $model = SysCity::query()->where(['id'=>$item->city_id])->first();
                        $cityName = $model->name;
                    }
                    return $cityName;
                }
            ],
            'weigh',
            'value' => [
                'filter' => 'like',
                'format' => function($item){
                    $html = number_format($item->value);
                    return $html;
                }
            ],
            'status'=>[
                'format' => function($item){
                    $html = self::getStatus($item->status);
                    return $html;
                }
            ],
        ]);
        return $grid;
    }
}
