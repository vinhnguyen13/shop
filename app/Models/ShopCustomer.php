<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopCustomer extends Model
{
    protected $table = 'shop_customer';
    protected $fillable = ['customer_group_id','user_id', 'name', 'email', 'address', 'country_id', 'city_id', 'district_id', 'ward_id', 'street_id', 'tax_code', 'phone', 'company', 'card', 'ip'];
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot() {
        parent::boot();
        static::saving(function($model) {
            foreach($model->attributes as $key => $value) {
                if($value === '') {
                    unset($model->attributes[$key]);
//                    $model->{$key} = null;
                }
            }

        });
    }
    /**
     * Create or update a related record matching the attributes, and fill it with values.
     *
     * @param  array  $attributes
     * @param  array  $values
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function updateOrCreate(array $attributes, array $values = [])
    {
        $instance = $this->firstOrNew($attributes);
        $instance->fill($values);
        $instance->save();
        return $instance;
    }
}
