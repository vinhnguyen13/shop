<?php
/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 2/9/2017
 * Time: 5:49 PM
 */

namespace App\Services;

use App\Helpers\Grid;
use DB;

class RevenueService
{
    public function gridIndex(){
        $query = DB::table('shop_order AS a');
        $grid = new Grid($query, [
            'id',
            'invoice_code',
            'customer_id' => [
                'label'=>'Customer',
                'filter' => 'like',
            ],
            'order_status_id',
            'total',
            'created_at',
            'updated_at',
        ]);
        return $grid;
    }
}