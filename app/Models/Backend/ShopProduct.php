<?php

namespace App\Models\Backend;

use App\Helpers\Grid;
use App\Models\ShopProduct as MainShopProduct;
use DB;

class ShopProduct extends MainShopProduct
{
    protected $fillable = ['category_id', 'supplier_id', 'sku', 'name', 'description', 'location', 'quantity', 'stock_status_id', 'image', 'manufacturer_id', 'shipping', 'price', 'points', 'tax_class_id', 'date_available', 'weight', 'weight_class_id', 'length', 'width', 'height', 'length_class_id', 'subtract', 'minimum', 'order', 'status'];

    public function gridIndex(){
        $query = DB::table('shop_product AS a');
        $grid = new Grid($query, [
            'id',
            'name' => [
                'label' => 'Name',
                'filter' => 'like',
            ],
            'sku',
            'price',
            'quantity',
            'status',
            'created_at',
        ]);
        return $grid;
    }
}
