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

    public function consignmentFeeValue($price)
    {
        if(empty($price)){
            return 0;
        }
        if($this->consignment_fee != 0){
            if($this->consignment_fee_type == ShopSupplier::CONSIGNMENT_FEE_TYPE_PERCENT){
                return $price * ($this->consignment_fee / 100);
            }else{
                return $this->consignment_fee;
            }
        }else{
            return $this->price - $this->price_in;
        }
    }
}
