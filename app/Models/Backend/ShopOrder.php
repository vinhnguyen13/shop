<?php

namespace App\Models\Backend;

use App\Helpers\Grid;
use App\Models\ShopOrder as MainShopOrder;
use App\Models\ShopOrderStatus;
use DB;

class ShopOrder extends MainShopOrder
{
    public function gridIndex($input){
        $query = DB::table('shop_order AS a');
        if(!empty($input['invoice_code'])) {
            $query->where('invoice_code', 'like', '%'.$input['invoice_code'].'%');
        }
        if(!empty($input['phone'])) {
//            $query->where(['billing_phone' => $input['phone']])->orWhere(['shipping_phone' => $input['phone']]);
            $query->where(function($query) use($input) {
                $query->orWhere('billing_phone', 'like', '%'.$input['phone'].'%')->orWhere('shipping_phone', 'like', '%'.$input['phone'].'%');
            });
        }
        if(!empty($input['status'])) {
            $query->where(['order_status_id' => $input['status']]);
        }

        $query->orderBy('created_at', 'desc');
        $grid = new Grid($query, [
            'id',
            'invoice_code'=>[
                'filter' => false,
                'label'=>'Invoice',
                'format' => function($item){
                    $html = $item->invoice_code.'<br/>';
                    $html .= '<button type="button" class="btn btn-primary btn-xs btn-print" data-url="'.route('product.payment.success', ['order'=>$item->id, 'print'=>1]).'"><i class="fa fa-check"></i>Print</button>';
                    return $html;
                }
            ],
            'billing' => [
                'custom' => true,
                'label'=>'Billing Info',
                'format' => function($item){
                    $html = '<p class="help-block small">';
                    $html .= '<b>Name:</b> '.$item->billing_name.'<br/>';
                    $html .= '<b>Addr:</b> '.$item->billing_address.'<br/>';
                    $html .= '<b>Phone:</b> '.$item->billing_phone.'<br/>';
                    $html .= '</p>';
                    return $html;
                }
            ],
            'shipping' => [
                'custom' => true,
                'label'=>'Shipping Info',
                'format' => function($item){
                    $html = '<p class="help-block small">';
                    $html .= '<b>Name:</b> '.$item->shipping_name.'<br/>';
                    $html .= '<b>Addr:</b> '.$item->shipping_address.'<br/>';
                    $html .= '<b>Phone:</b> '.$item->shipping_phone.'<br/>';
                    $html .= '</p>';
                    return $html;
                }
            ],
            'seller' => [
                'custom' => true,
                'label'=>'Seller',
                'format' => function($item){
                    $user = User::find($item->seller_id);
                    $html = !empty($user->id) ? $user->name : 'Null';
                    return $html;
                }
            ],
            'order_status_id' => [
                'filter' => false,
                'label'=>'Status',
                'format' => function($item){
                    $count = ShopOrderProduct::query()->where(['order_id'=>$item->id])->count();
                    $html = ShopOrderStatus::getStatus($item->order_status_id);
                    $html .= '<p class="help-block small">'.\Html::link(route('admin.order-product.index', ['order_id'=>$item->id]), 'Products: '.$count, ['target'=>'_blank']).'</p>';
                    $btnColorClass = 'btn-danger';
                    $btnLabel = 'Cancel';
                    if($item->order_status_id != ShopOrderStatus::STT_COMPLETE) {
                        $btnColorClass = 'btn-primary';
                        $btnLabel= 'Update';
                    }
                    $html .= '<button type="button" class="btn '.$btnColorClass.' btn-xs btn-update-order" data-order="'.$item->id.'" data-order-status="'.$item->order_status_id.'"><i class="fa fa-check"></i>'.$btnLabel.'</button>';
                    return $html;
                }
            ],
            'products' => [
                'custom' => true,
                'label'=>'Products',
                'format' => function($item){
                    $orderDetails = ShopOrderDetail::query()->where(['order_id'=>$item->id])->get();
                    $html = '';
                    if(!empty($orderDetails)){
                        $html .= '<p class="help-block small">';
                        foreach($orderDetails as $key=>$orderDetail){
                            $html .= '<b>Product '.($key+1).':</b> <a href="'.route('admin.product.index', ['id'=>$orderDetail->product->id]).'">'.$orderDetail->product->name. '</a> - Size: '.$orderDetail->size.' - Quantity: '.$orderDetail->quantity.'<br/>';
                        }
                        $html .= '</p>';
                    }
                    return $html;
                }
            ],
            'total_price' => [
                'filter' => false,
                'label'=>'Price',
                'format' => function($item){
                    $html = number_format($item->total_price);
                    return $html;
                }
            ],
            'total_shipping' => [
                'filter' => false,
                'label'=>'Shipping',
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
        $grid->setHiddenColumn(['seller_id', 'billing_name', 'billing_address', 'billing_phone', 'shipping_name', 'shipping_address', 'shipping_phone']);
        $grid->removeActionColumn();
        return $grid;
    }
}
