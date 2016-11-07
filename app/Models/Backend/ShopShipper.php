<?php

namespace App\Models\Backend;

use App\Helpers\Grid;
use App\Models\ShopOrder as MainShopShipper;
use DB;

class ShopShipper extends MainShopShipper
{
    public function gridIndex(){
        $query = DB::table('shop_shipper AS a');
        $grid = new Grid($query, [
            'id',
            'firstname',
            'lastname',
            'company',
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

        $instance->save();

        return $instance;
    }
}
