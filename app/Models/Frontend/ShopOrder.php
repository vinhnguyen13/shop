<?php

namespace App\Models\Frontend;

use App\Models\ShopOrder as Model;

class ShopOrder extends Model
{
    /**
     * Create or update a related record matching the attributes, and fill it with values.
     *
     * @param  array $attributes
     * @param  array $values
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function updateOrCreate(array $attributes, array $values = [])
    {
        $instance = $this->firstOrNew($attributes);
        $instance->fill($values);
        $validate = $instance->validate($instance->attributes);
        $instance->processingSave($values);
        if ($validate->passes()) {

        }
    }

    public function processingSave($values)
    {

    }
}
