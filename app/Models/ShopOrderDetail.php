<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopOrderDetail extends Model
{
    protected $table = 'shop_order_detail';
    public $timestamps = false;

    public function order()
    {
        return $this->hasOne('App\Models\ShopOrder', 'id', 'order_id');
    }

    public function product()
    {
        return $this->hasOne('App\Models\ShopProduct', 'id', 'product_id');
    }

    public function getSize(){
        return $this->size;
    }
}
