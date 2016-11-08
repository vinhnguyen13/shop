<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CpHistory extends Model
{
    const STATUS_ACTIVE = 1;

    protected $table = 'cp_history';
    public $timestamps = false;

    public function code()
    {
        return $this->hasOne('App\Models\CpCode', 'id', 'cp_code_id');
    }

    public static function checkCoupon($user_id, $code)
    {
        if(empty($user_id)){
            return ['error_code'=>1, 'error_message'=>trans('User not found')];
        }
        $coupon = CpCode::query()->where(['code' => $code])->where(['status' => self::STATUS_ACTIVE])->first();
        if(!empty($coupon)){
            $coupon_event = $coupon->event()->first();
            $time = time();
            if($coupon_event->start_date <= $time && $coupon_event->end_date >= $time) {
                $coupon_id = $coupon->id;
                $history = CpHistory::query()->where(['cp_code_id' => $coupon_id, 'user_id' => $user_id])->first();
                if($coupon->use_repeat == 0 && !empty($history)){
                    return ['error_code'=>1, 'error_message'=>trans('You used this code')];
                }
                if (!$coupon->check()) {
                    return ['error_code'=>1, 'error_message'=>trans('This code is used')];
                }
                $cp_history = new CpHistory();
                $cp_history->user_id = $user_id;
                $cp_history->cp_code_id = $coupon_id;
                $cp_history->cp_event_id = $coupon->cp_event_id;
                $cp_history->created_at = time();
                if ($cp_history->save()) {
                    $coupon->count = $coupon->count + 1;
                    $coupon->save();
                }
                return ['error_code'=>0, 'result'=>$cp_history];

            }else{
                return ['error_code'=>1, 'error_message'=>trans('Event has expired')];
            }
        }
        return ['error_code'=>1, 'error_message'=>trans('Code not found')];
    }
}
