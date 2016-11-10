<?php

namespace App\Models\Backend;

use App\Helpers\Grid;
use App\Models\ShopProduct as MainShopProduct;
use DB;

class ShopProduct extends MainShopProduct
{
    public function gridIndex(){
        $query = DB::table('shop_product AS a');
        $grid = new Grid($query, [
            'id',
            'name' => [
                'label' => 'Name',
                'filter' => 'like',
            ],
            'sku',
            'price',
            'quantity',
            'status',
            'created_at',
        ]);
        return $grid;
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
        $validate = $instance->validate($instance->attributes, $instance->rules());
        if($validate->passes()){
            $instance->save();
            return $instance;
        }else{
            return $validate->getMessageBag();
        }
    }
}
