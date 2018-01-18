<?php

namespace App\Models\Backend;

use App\Helpers\Grid;
use App\Models\ShopSupplier as Model;
use DB;
use App\Models\Backend\ShopProductDetail;

class ShopSupplier extends Model
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
            'product' => [
                'custom' => true,
                    'label' => 'Product',
                    'format' => function ($item) {
                        $totalProduct = ShopProductDetail::query()->where(['supplier_id'=>$item->id])->count();
                        $html = \Html::link(route('admin.product-detail.index', ['supplier_id'=>$item->id]), $totalProduct);
                    return $html;
                }
            ]
        ]);
        return $grid;
    }
}
