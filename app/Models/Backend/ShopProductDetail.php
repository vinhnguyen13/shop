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
        $query->orderBy('created_at', 'asc');
        $grid = new Grid($query, [
            'id',
            'product_id'=>[
                'label'=>'Product',
                'format' => function($item){
                    $model = ShopProduct::query()->where(['id'=>$item->product_id])->first();
                    $return = $model->name.' ( ';
                    $return .= \Html::link(route('admin.product.index', ['id'=>$item->product_id]), 'Info');
                    $return .= ' | '.\Html::link(route('admin.product.edit', ['id'=>$item->product_id]), 'Import Stock');
                    $return .= ' )';
                    return $return;
                },
                'filter' => [function($column, $config, $input){
                    $html = \Form::text("product_id", !empty($input[$column]) ? $input[$column] : null, ['class' => 'simple-filter']);
                    return $html;
                }, function($column, $config, $query, $input){
                    if(!empty($input["{$column}"])) {
                        $word = $input[$column];
                        $query->leftJoin('shop_product AS b', "b.id", '=', 'a.product_id');
                        $query->where('b.id', '=', $word)->orWhere('b.name', 'Like', '%'.$word.'%');
                    }
                }]
            ],
            'supplier_id'=>[
                'label'=>'Supplier',
                'format' => function($item){
                    $model = ShopSupplier::query()->where(['id'=>$item->supplier_id])->first();
                    $html = \Html::link(route('admin.supplier.index', ['id'=>$item->supplier_id]), $model->name).' ('.$model->consignmentFeeLabel().')';
                    $html .= '<p class="help-block small">Consignment Fee: '.number_format($item->consignment_fee).'%</p>';
                    return $html;
                },
            ],
            'sku',
            'qr'=>[
                'custom' => true,
                'label' => 'QR',
                'format'=>function($item){
                    $productDetail = ShopProductDetail::find($item->id);
                    $html = '<img width="100" src="'.route('admin.product-detail.qrcode', ['id'=>$item->id]).'">';
                    $html = '<a class="glyphicon glyphicon-eye-open" id="view-qrcode" href="javascript:;" ' .
                        'data-img-src="'.route('admin.product-detail.qrcode', ['id'=>$item->id]).'"' .
                        'data-sku="'.$item->sku.'"' .
                        'data-product-url="'.$productDetail->product->url().'"' .
                        '></a>';
                    return $html;
                }
            ],
            'size',
            'price_in'=>[
                'label'=>'Price In',
                'format' => function($item) {
                    return number_format($item->price_in);
                }
            ],
            'price'=>[
                'label'=>'Price',
                'format' => function($item) {
                    return number_format($item->price);
                }
            ],
            'new_status'=>[
                'label'=>'New Status',
                'format' => function($item) {
                    return ShopProductDetail::find($item->id)->getTextNewStatus();
                }
            ],
            'stock_status_id'=>[
                'label'=>'Stock Status',
                'format' => function($item) {
                    return app(self::class)->getStockStatus($item->stock_status_id);
                }
            ],
            'stock_out_date',
            'stock_in_date',
            'created_at',
            'updated_at',
            'custom_column' => [
                'custom' => true,
                'label' => 'Action',
                'format' => function($item) {
                    $uri = \Request::route()->getUri();
                    $show = link_to(url("$uri/show", [$item->id]), '', ['class' => 'glyphicon glyphicon-eye-open', 'data-toggle' => 'tooltip', 'data-original-title' => 'View']);
                    $delete = link_to(url("$uri/delete", [$item->id]), '', ['class' => 'glyphicon glyphicon-trash glyphicon-last-child', 'data-toggle' => 'tooltip', 'data-original-title' => 'Delete']);
                    return $show;
                }
            ]
        ]);
        $grid->removeActionColumn();
        $grid->setHiddenColumn(['consignment_fee']);
        return $grid;
    }
}
