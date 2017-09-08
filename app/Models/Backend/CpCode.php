<?php

namespace App\Models\Backend;

use App\Models\CpCode as Model;
class CpCode extends Model
{

    public static function saveRandomCode($post)
    {
        if(count($post) > 0 && isset($post['length'])){
            $no_of_coupons = intval($post['no_of_coupons']);
            $length = $post['length'];
            $prefix = $post['prefix'];
            $suffix = $post['suffix'];
            $numbers = $post['numbers'];
            $letters = $post['letters'];
            $symbols = $post['symbols'];
            $random_register = $post['random_register'] == 'false' ? false : true;
            $mask = $post['mask'] == '' ? false : $post['mask'];
            for ($i = 0; $i < $no_of_coupons; $i++) {
                $coupon_code = Coupon::generate($length, $prefix, $suffix, $numbers, $letters, $symbols, $random_register, $mask);
                $code = CpCode::generateCodeExists($coupon_code, $length, $prefix, $suffix, $numbers, $letters, $symbols, $random_register, $mask);
                if(!empty($code)){
                    $event_id = (isset($post["cp_event_id"])) ? intval($post["cp_event_id"]) : 0;
                    $limit = (isset($post["limit"])) ? intval($post["limit"]) : 2;
                    $amount = (isset($post["amount"])) ? intval($post["amount"]) : 0;
                    $amount_type = (isset($post["CouponCode"]["amount_type"])) ? intval($post["CouponCode"]["amount_type"]) : 1;

                    $model = new CpCode();
                    $model->code = $code;
                    $model->cp_event_id = $event_id;
                    $model->limit = $limit;
                    $model->amount = $amount;
                    $model->amount_type = $amount_type;
                    $model->created_at = $model->updated_at = time();
                    $model->save();
                }
            }
            return true;
        }
        return false;
    }

}
