<?php
/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 2/9/2017
 * Time: 5:49 PM
 */

namespace App\Services;

use App\Helpers\Grid;
use App\Models\Backend\ShopOrder;
use App\Models\Backend\ShopOrderProduct;
use App\Models\Backend\ShopProduct;
use App\Models\Backend\ShopProductDetail;
use App\Models\Backend\ShopSupplier;
use DB;

class RevenueService
{
    public function gridOrders(){
        $query = ShopOrderProduct::query();
        $orders = $query->get();
        return $orders;
    }

    public function gridIndex(){
        $query = DB::table('shop_order_product AS a');
        $grid = new Grid($query, [
            'id'=>[
                'filter'=>false
            ],
            'date' => [
                'custom' => true,
                'label' => 'Date',
                'format' => function($item){
                    $order = ShopOrder::query()->where(['id'=>$item->order_id])->first();
                    return $order->created_at;
                }
            ],
            'sku',
            'supplier_id'=>[
                'label'=>'Supplier',
                'filter'=>false,
                'format' => function($item){
                    $model = ShopSupplier::query()->where(['id'=>$item->supplier_id])->first();
                    $title = '<a href="'.route('admin.supplier.index', ['id'=>$item->supplier_id]).'">'.$model->name.'</a><br>';
                    $title .= '<p class="help-block small">Discount: '.number_format($model->discount_available).' %</p>';
                    return $title;
                },
            ],
            'product_name'=>[
                'label'=>'Product',
                'filter'=>false
            ],
            'size'=>[
                'filter'=>false
            ],
            'quantity'=>[
                'label'=>'QTY',
                'filter'=>false
            ],
//            'price_in',
            'price'=>[
                'filter'=>false,
                'format' => function($item){
                    $priceHtml = number_format($item->price).'<br/>';
                    $priceHtml .= '<p class="help-block small">Price In: '.number_format($item->price_in).'</p>';
                    return $priceHtml;
                },
            ],
            'total'=>[
                'label' => 'Payment',
                'filter'=>false,
                'format' => function($item){
                    return number_format($item->total);
                },
            ],
            'revenue' => [
                'custom' => true,
                'label' => 'Revenue',
                'format' => function($item){
                    $supplier = ShopSupplier::query()->where(['id'=>$item->supplier_id])->first();
                    $revenue = $item->total * $supplier->discount_available / 100;
                    return number_format($revenue);
                }
            ],
            'consignment_payment' => [
                'custom' => true,
                'label' => 'Consignment Payment',
                'format' => function($item){
                    $supplier = ShopSupplier::query()->where(['id'=>$item->supplier_id])->first();
                    $revenue = $item->total - ($item->total * $supplier->discount_available / 100);
                    $consignmentPaymentHtml = number_format($revenue);
                    $consignmentPaymentHtml .= '<p class="help-block small">Payment Date: '.date('d-m-Y').'</p>';
                    return $consignmentPaymentHtml;
                }
            ]

        ]);
        $grid->removeActionColumn();
        $grid->setHiddenColumn(['price_in', 'order_id']);
        return $grid;
    }
}