<?php

namespace App\Models\Backend;

use App\Helpers\Grid;
use App\Models\ShopSupplier as MainShopSupplier;
use DB;

class ShopSupplier extends MainShopSupplier
{
    protected $fillable = ['company_name', 'contact_name', 'contact_title', 'address', 'country_id', 'city_id', 'district_id',
        'phone', 'fax', 'email', 'card', 'url', 'payment_method', 'discount_type', 'type_goods', 'notes', 'discount_available', 'current_order', 'logo', 'customer_id'];

    public function gridIndex(){
        $query = DB::table('shop_supplier AS a');
        $grid = new Grid($query, [
            'id',
            'company_name',
            'contact_name',
            'contact_title',
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
