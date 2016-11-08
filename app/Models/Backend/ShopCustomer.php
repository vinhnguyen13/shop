<?php

namespace App\Models\Backend;

use App\Helpers\Grid;
use App\Models\ShopCustomer as MainShopCustomer;
use DB;

class ShopCustomer extends MainShopCustomer
{
    protected $fillable = ['customer_group_id', 'firstname', 'lastname', 'phone', 'fax', 'email', 'card', 'company', 'address_1',
        'address_2', 'country_id', 'city_id', 'district_id'];

    public function gridIndex(){
        $query = DB::table('shop_customer AS a');
        $grid = new Grid($query, [
            'id',
            'firstname',
            'lastname',
            'phone',
            'fax',
            'email',
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
        $instance->save();
        return $instance;
    }
}
