<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopOrderProduct extends Model
{
    protected $table = 'shop_order_product';

    public function order()
    {
        return $this->hasOne('App\Models\ShopOrder', 'id', 'order_id');
    }

    public function product()
    {
        return $this->hasOne('App\Models\ShopProduct', 'id', 'product_id');
    }

    public function productDetail()
    {
        return $this->hasOne('App\Models\ShopProductDetail', 'id', 'product_detail_id');
    }

    public function supplier()
    {
        return $this->hasOne('App\Models\ShopSupplier', 'id', 'supplier_id');
    }
}
