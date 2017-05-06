<?php

namespace App\Models\Backend;

use App\Helpers\Grid;
use App\Models\ShopOrderProduct as Model;
use DB;

class ShopOrderProduct extends Model
{
    public function gridIndex(){
        $query = DB::table('shop_order_product AS a');
        $grid = new Grid($query, [
            'id',
            'order_id'=>[
                'label'=>'Order',
                'format' => function($item){
                    $model = ShopOrder::query()->where(['id'=>$item->order_id])->first();
                    $html = \Html::link(route('admin.order.index', ['id'=>$model->id]), $model->invoice_code);
                    $html .= '<p class="help-block small">Discount: '.number_format($model->discount_available).'%</p>';
                    return $html;
                },
            ],
            'sku',
            'supplier_id'=>[
                'label'=>'Supplier',
                'format' => function($item){
                    $model = ShopSupplier::query()->where(['id'=>$item->supplier_id])->first();
                    $html = \Html::link(route('admin.supplier.index', ['id'=>$item->supplier_id]), $model->name);
                    $html .= '<p class="help-block small">Consignment Fee: '.number_format($model->consignment_fee).'%</p>';
                    return $html;
                },
            ],
            'product_name'=>[
                'format' => function($item){
                    $html = \Html::link(route('admin.product-detail.index', ['product_id'=>$item->product_id]), $item->product_name);
                    return $html;
                },
            ],
            'size',
            'quantity',
            'price'=>[
                'label'=>'Price',
                'format' => function($item){
                    $html = number_format($item->price).'<br/>';
                    $html .= '<p class="help-block small">Price In: '.number_format($item->price_in).'</p>';
                    return $html;
                },
            ],
            'total'=>[
                'label'=>'Payment',
                'format' => function($item){
                    $html = number_format($item->total);
                    return $html;
                },
            ],
            'created_at',
            'updated_at',

        ]);
        $grid->setHiddenColumn(['product_id', 'price_in']);
        $grid->removeActionColumn();
        return $grid;
    }
}
