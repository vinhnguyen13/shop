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
    public function gridRevenue(){
        $query = ShopOrderProduct::query();
        $orders = $query->paginate(30,['*'],'trang');
        return $orders;
    }

    public function gridPaymentConsignment(){
        $query = ShopOrderProduct::query();
        $query->join('shop_product_detail', function($join){
            $join->on('shop_product_detail.id', '=', 'shop_order_product.product_detail_id')
                ->where('pay_to_supplier_status', '=', ShopProductDetail::PAY_SUPPLIER_PENDING);
        });
        $orders = $query->paginate(30,['*'],'trang');
        return $orders;
    }
}