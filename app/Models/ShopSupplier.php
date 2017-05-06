<?php

namespace App\Models;

use App\Models\Traits\HasValidator;
use Illuminate\Database\Eloquent\Model;

class ShopSupplier extends Model
{
    use HasValidator;
    protected $table = 'shop_supplier';
    protected $fillable = ['name', 'code', 'address', 'country_id', 'city_id', 'district_id',
        'phone', 'fax', 'email', 'payment_method', 'consignment_fee_type', 'consignment_fee', 'type_goods', 'notes', 'order', 'url', 'logo'];

    const PREFIX_CODE = 'ch';
    const CONSIGNMENT_FEE_TYPE_PERCENT = 1;
    const CONSIGNMENT_FEE_TYPE_PRICE = 2;
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
            $code = self::PREFIX_CODE . str_pad($this->id, 2, '0', STR_PAD_LEFT);
            $this->update(['code' => $code]);
        }
    }

    public static function consignmentFeeTypeLabel($id = null)
    {
        $data = [
            self::CONSIGNMENT_FEE_TYPE_PERCENT => '%',
            self::CONSIGNMENT_FEE_TYPE_PRICE => 'VND',
        ];

        if ($id !== null && isset($data[$id])) {
            return $data[$id];
        } else {
            return $data;
        }
    }

    public function consignmentFeeLabel()
    {
        if($this->consignment_fee_type == self::CONSIGNMENT_FEE_TYPE_PERCENT){
            return number_format($this->consignment_fee).' %';
        }else{
            return number_format($this->consignment_fee).' VND';
        }
    }

    public function consignmentFeeValue($price)
    {
        if(empty($price)){
            return 0;
        }
        if($this->consignment_fee_type == self::CONSIGNMENT_FEE_TYPE_PERCENT){
            return $price * ($this->consignment_fee / 100);
        }else{
            return $this->consignment_fee;
        }
    }
}
