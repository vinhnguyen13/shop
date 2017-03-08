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
    public function gridRevenue($params){
        $query = ShopOrderProduct::query();
        if(!empty($params['from_date']) & !empty($params['to_date'])){
            $query->whereBetween('created_at', [$params['from_date'], $params['to_date']]);
        }
        if(!empty($params['supplier'])){
            $query->whereIn('supplier_id', [$params['supplier']]);
        }
        if(isset($params['debt'])){
            $debtStatus = $params['debt'];
            if($debtStatus == ShopProductDetail::DEBT_PAYMENT_DUE_DATE){
                $debtStatus = ShopProductDetail::DEBT_PENDING;
                $query->where('created_at', '<=', DB::raw('DATE_ADD(CURDATE(), INTERVAL -4 DAY)'));
            }
            $query->where('debt_status', '=', $debtStatus);
        }
        $orders = $query->paginate(30,['*'],'trang');
        return $orders;
    }

    public function gridPaymentConsignment($params){
        $query = ShopOrderProduct::query();
        $query->where('debt_status', '=', ShopProductDetail::DEBT_PENDING)->where('created_at', '<=', DB::raw('DATE_ADD(CURDATE(), INTERVAL -4 DAY)'));
        $orders = $query->paginate(30,['*'],'trang');
        return $orders;
    }
}