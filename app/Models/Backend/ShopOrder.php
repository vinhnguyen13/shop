<?php

namespace App\Models\Backend;

use App\Helpers\Grid;
use App\Models\ShopOrder as MainShopOrder;
use App\Models\ShopOrderStatus;
use DB;

class ShopOrder extends MainShopOrder
{
    public function gridIndex(){
        $query = DB::table('shop_order AS a');
        $grid = new Grid($query, [
            'id',
            'invoice_code',
            'customer_id' => [
                'label'=>'Customer',
                'filter' => 'like',
            ],
            'order_status_id' => [
                'filter' => false,
                'format' => function($item){
                    $count = ShopOrderProduct::query()->where(['order_id'=>$item->id])->count();
                    $html = ShopOrderStatus::getStatus($item->order_status_id);
                    $html .= '<p class="help-block small">'.\Html::link(route('admin.order-product.index', ['order_id'=>$item->id]), 'Products: '.$count, ['target'=>'_blank']).'</p>';
                    return $html;
                }
            ],
            'total_price' => [
                'filter' => false,
                'format' => function($item){
                    $html = number_format($item->total_price);
                    return $html;
                }
            ],
            'total_tax' => [
                'filter' => false,
                'format' => function($item){
                    $html = number_format($item->total_tax);
                    return $html;
                }
            ],
            'total_shipping' => [
                'filter' => false,
                'format' => function($item){
                    $html = number_format($item->total_shipping);
                    return $html;
                }
            ],
            'total' => [
                'filter' => false,
                'format' => function($item){
                    $html = number_format($item->total);
                    return $html;
                }
            ],

            'created_at',
            'updated_at',
        ]);
        return $grid;
    }
}
