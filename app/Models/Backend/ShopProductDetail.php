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
                    return \Html::link(route('admin.supplier.index', ['id'=>$item->supplier_id]), $model->name);
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
            'price_in',
            'price',
            'new_status',
            'stock_status_id'=>[
                'label'=>'Stock Status',
                'format' => function($item) {
                    return app(self::class)->getStockStatus($item->stock_status_id);
                }
            ],
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
        return $grid;
    }
}
