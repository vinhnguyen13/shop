<?php

namespace App\Models;

use App\Models\Traits\HasValidator;
use Illuminate\Database\Eloquent\Model;

class ShopOrder extends Model
{
    use HasValidator;
    protected $table = 'shop_order';
    protected $fillable = ['store_id', 'store_name', 'store_url', 'customer_id', 'customer_group_id',
    'firstname', 'lastname', 'email', 'telephone', 'fax', 'custom_field'];

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
            'shipping_name' => 'required',
            'shipping_address' => 'required',
            'shipping_phone' => 'required',
        ];
    }

}
