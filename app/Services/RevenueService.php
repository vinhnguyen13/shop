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
        $orders = $query->paginate(30,['*'],'trang');
        return $orders;
    }
}