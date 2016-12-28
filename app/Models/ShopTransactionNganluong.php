<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class EcTransactionNganluong extends Model
{
    protected $table = 'shop_transaction_nganluong';
    //

    public function saveTransactionNganluong($transaction_code, $data){
        $transaction_nganluong = $this->getTransactionNganluong(['transaction_code'=>$transaction_code]);
        if(!empty($transaction_nganluong)){
            $attributes = array_collapse([[
                'updated_at' => time(),
            ], $data]);
        }else{
            $attributes = array_collapse([[
                'transaction_code' => $transaction_code,
                'created_at' => time(),
            ], $data]);
        }
        if($transaction_nganluong->setRawAttributes($attributes)->save()) {
            return $transaction_nganluong;
        }
        return false;
    }

    public function getTransactionNganluong($condition){
        $transaction_nganluong = $this->newQuery()->from('ec_transaction_nganluong AS a')->select(['id','token','transaction_code'])->where($condition)->first();
        if(!empty($transaction_nganluong)){
            return $transaction_nganluong;
        }else{
            return new EcTransactionNganluong();
        }
    }

    public function getTransactionWithNganluong($condition){
        $transaction_nganluong = $this->newQuery()->from('ec_transaction_nganluong AS a')->select(['code','user_id','object_id','object_type','b.amount','balance','b.status','b.params','b.created_at','b.updated_at','a.payment_method','a.amount AS amount_vnd'])
            ->where($condition)
            ->join('ec_transaction_history AS b', function($join){
                $join->on('b.code', '=', 'a.transaction_code');
            })
            ->first();
        if(!empty($transaction_nganluong)){
            return $transaction_nganluong;
        }
    }
}
