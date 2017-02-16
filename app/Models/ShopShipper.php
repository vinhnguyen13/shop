<?php

namespace App\Models;

use App\Models\Traits\HasValidator;
use Illuminate\Database\Eloquent\Model;

class ShopShipper extends Model
{
    use HasValidator;
    protected $table = 'shop_shipper';
    protected $fillable = ['firstname', 'lastname', 'phone', 'fax', 'email', 'company', 'address_1', 'address_2', 'country_id', 'city_id', 'district_id'];

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
