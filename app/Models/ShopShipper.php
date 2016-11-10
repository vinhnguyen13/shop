<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopShipper extends Model
{
    protected $table = 'shop_shipper';
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
}
