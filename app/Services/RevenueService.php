<?php
/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 2/9/2017
 * Time: 5:49 PM
 */

namespace App\Services;

use App\Helpers\Grid;
use App\Models\Backend\ShopProduct;
use App\Models\Backend\ShopProductDetail;
use App\Models\Backend\ShopSupplier;
use DB;

class RevenueService
{
    public function gridIndex(){
        $query = DB::table('shop_order_product AS a');
        $grid = new Grid($query, [
            'id',
            'product_name',
            'supplier_id'=>[
                'label'=>'Supplier',
                'format' => function($item){
                    $model = ShopSupplier::query()->where(['id'=>$item->supplier_id])->first();
                    $title = $model->name.' - Discount: '.number_format($model->discount_available).' %';
                    return \Html::link(route('admin.supplier.index', ['id'=>$item->supplier_id]), $title);
                },
            ],
            'size',
            'price_in'=>[
                'format' => function($item){
                    return number_format($item->price_in);
                },
            ],
            'price'=>[
                'format' => function($item){
                    return number_format($item->price);
                },
            ],
            'quantity'=>[
                'filter'=>false
            ],
            'total'=>[
                'format' => function($item){
                    return number_format($item->total);
                },
            ],
            'custom_column' => [
                'custom' => true,
                'label' => 'Revenue',
                'format' => function($item){
                    $supplier = ShopSupplier::query()->where(['id'=>$item->supplier_id])->first();
                    $revenue = $item->total * $supplier->discount_available / 100;
                    return number_format($revenue);
                }
            ]
        ]);
        $grid->removeActionColumn();
        return $grid;
    }
}