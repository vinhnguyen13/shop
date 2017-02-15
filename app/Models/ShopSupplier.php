<?php

namespace App\Models;

use App\Models\Traits\HasValidator;
use Illuminate\Database\Eloquent\Model;

class ShopSupplier extends Model
{
    use HasValidator;
    protected $table = 'shop_supplier';
    protected $fillable = ['name', 'code', 'address', 'country_id', 'city_id', 'district_id',
        'phone', 'fax', 'email', 'payment_method', 'discount_type', 'discount_available', 'type_goods', 'notes', 'order', 'url', 'logo'];

    const prefix_code = 'ch';
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
        $instance->updateCode();
        return $instance;
    }


    public function updateCode()
    {
        if(empty($this->code)) {
            $code = self::prefix_code . str_pad($this->id, 2, '0', STR_PAD_LEFT);
            $this->update(['code' => $code]);
        }
    }
}
