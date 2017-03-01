<?php

namespace App\Models;

use App\Models\Traits\HasValidator;
use Illuminate\Database\Eloquent\Model;

class ShopShipFee extends Model
{
    use HasValidator;
    protected $table = 'shop_ship_fee';
    protected $fillable = ['country_id', 'city_id', 'weigh', 'type', 'value', 'status'];

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

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

    /**
     * @param null $id
     * @return array
     */
    public static function getStatus($id = null)
    {
        $data = [
            self::STATUS_INACTIVE => 'InActive',
            self::STATUS_ACTIVE => 'Active',
        ];

        if ($id !== null && isset($data[$id])) {
            return $data[$id];
        } else {
            return $data;
        }
    }

}
