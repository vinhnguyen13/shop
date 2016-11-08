<?php

namespace App\Models;

use App\Models\Backend\Coupon;
use Illuminate\Database\Eloquent\Model;

class CpCode extends Model
{

    const TYPE_ONE = 1;
    const TYPE_MANY = 2;

    const AMOUNT_TYPE_PERCENT = 1;
    const AMOUNT_TYPE_PRICE = 2;

    protected $table = 'cp_code';
    public $timestamps = false;

    protected $guarded = ['id'];
    protected $fillable = ['code', 'cp_event_id', 'status', 'count', 'limit', 'created_at', 'updated_at', 'amount', 'amount_type'];

    public function event()
    {
        return $this->hasOne('App\Models\CpEvent', 'id', 'cp_event_id');
    }

    public static function getAmountTypes($id = null)
    {
        $data = [
            self::AMOUNT_TYPE_PERCENT => 'Percent',
            self::AMOUNT_TYPE_PRICE => 'Amount'
        ];

        if ($id !== null && isset($data[$id])) {
            return $data[$id];
        } else {
            return $data;
        }
    }

    public static function generateCodeExists($code, $length, $prefix, $suffix, $numbers, $letters, $symbols, $random_register, $mask)
    {
        if(!empty($code)){
            $coupon = CpCode::where('code', $code)->get()->first();
            if(count($coupon) > 0) {
                $code = Coupon::generate($length, $prefix, $suffix, $numbers, $letters, $symbols, $random_register, $mask);
                return CpCode::generateCodeExists($code, $length, $prefix, $suffix, $numbers, $letters, $symbols, $random_register, $mask);
            }
            else {
                return $code;
            }
        }
        return null;
    }

    public function check()
    {
        if (($this->limit == 1 && $this->count < 1) || ($this->limit > 1 && $this->limit > $this->count) || $this->limit == 0) {
            return true;
        }
        return false;
    }

    public static $rules = [
        'code' => 'required|unique:cp_code|max:32',
        'limit' => 'integer',
        'amount' => 'required|numeric'
    ];
}
