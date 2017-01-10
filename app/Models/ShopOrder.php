<?php

namespace App\Models;

use App\Models\Traits\HasValidator;
use Illuminate\Database\Eloquent\Model;

class ShopOrder extends Model
{
    use HasValidator;
    protected $table = 'shop_order';
    protected $fillable = ['invoice_code', 'name', 'email', 'billing_name', 'billing_address', 'billing_country_id', 'billing_city_id', 'billing_district_id', 'billing_ward_id', 'billing_phone', 'billing_tax_code', 'shipping_name', 'shipping_address', 'shipping_country_id', 'shipping_city_id', 'shipping_district_id', 'shipping_ward_id', 'shipping_phone', 'payment_method', 'payment_method_id', 'payment_code', 'shipper_id', ''];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            foreach ($model->attributes as $key => $value) {
                if ($value === '') {
                    unset($model->attributes[$key]);
//                    $model->{$key} = null;
                }
            }

        });
    }

    public function rules()
    {
        return [
            'total_price' => 'required',
            'total' => 'required',
        ];
    }

}
