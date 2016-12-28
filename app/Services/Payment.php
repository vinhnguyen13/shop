<?php
/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 6/16/2016
 * Time: 4:47 PM
 */

namespace App\Services;

use App\Models\EcTransactionHistory;
use DB;
use Auth;

class Payment
{
    public function payWithNganLuong($redirect, $paymentOption){
        $transaction_code = md5(uniqid(rand(), true));
        /**
         * Banking
         */
        if(!empty($paymentOption) && $paymentOption == NganLuong::METHOD_BANKING){
            if(!empty($amount) && is_numeric($amount)){
                DB::beginTransaction();
                try {
                    app()->make(EcTransactionHistory::class)->saveTransaction($transaction_code, [
                        'code'=>$transaction_code,
                        'user_id'=>Auth::user()->id,
                        'object_id'=>NganLuong::METHOD_BANKING,
                        'object_type'=>EcTransactionHistory::OBJECT_TYPE_BUY_KEYS,
                        'amount'=>$amount,
                        'balance'=>0,
                        'status'=>EcTransactionHistory::STATUS_PENDING,
                    ]);
                    $data = array_collapse([
                        [
                            'return_url' => route('payment.success', ['redirect'=>$redirect]),
                            'cancel_url' => route('payment.cancel'),
                            'transaction_code' => $transaction_code,
                        ],
                        $_POST
                    ]);
                    $return = app()->make(NganLuong::class)->payByBank($data);
                    DB::commit();
                    return $return;
                } catch (\Exception $e) {
                    DB::rollBack();
                    throw $e;
                }
            }else{
                abort(500, 'Amount not real.');
            }
        }

        /**
         * Mobile Card
         */
        if(!empty($paymentOption) && $paymentOption == NganLuong::METHOD_MOBILE_CARD){
            DB::beginTransaction();
            try {
                app()->make(EcTransactionHistory::class)->saveTransaction($transaction_code, [
                    'code'=>$transaction_code,
                    'user_id'=>Auth::user()->id,
                    'object_id'=>NganLuong::METHOD_MOBILE_CARD,
                    'object_type'=>EcTransactionHistory::OBJECT_TYPE_BUY_KEYS,
                    'amount'=>0,
                    'balance'=>0,
                    'status'=>EcTransactionHistory::STATUS_PROCESSING,
                ]);
                $data = array_collapse([
                    [
                        'transaction_code' => $transaction_code,
                        'user_id'=>Auth::user()->id,
                    ],
                    $_POST
                ]);
                $return = app()->make(NganLuong::class)->payByMobiCard($data);
                DB::commit();
                return $return;
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        }
    }
}