<?php

namespace App\Models\Backend;

use App\Helpers\Grid;
use App\Models\ShopProductDetail as MainShopProductDetail;
use DB;
use Carbon\Carbon;

class ShopProductDetail extends MainShopProductDetail
{
    public function gridIndex(){
        $query = DB::table('shop_product_detail AS a');
        $grid = new Grid($query, [
            'id',
            'product_id'=>[
                'label'=>'Product',
                'format' => function($item){
                    $model = ShopProduct::find($item->product_id)->first();
                    return $model->name;
                },
            ],
            'supplier_id'=>[
                'label'=>'Supplier',
                'format' => function($item){
                    $model = ShopSupplier::find($item->supplier_id)->first();
                    return $model->name;
                },
            ],
            'sku',
            'size',
            'price_in',
            'price',
            'new_status',
        ]);
        return $grid;
    }
}
