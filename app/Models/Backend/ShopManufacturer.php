<?php

namespace App\Models\Backend;

use App\Helpers\Grid;
use App\Models\ShopManufacturer as MainShopManufacturer;
use DB;

class ShopManufacturer extends MainShopManufacturer
{
    public function gridIndex(){
        $query = DB::table('shop_manufacturer AS a');
        $grid = new Grid($query, [
            'id',
            'name' => [
                'label' => 'Name',
                'filter' => 'like',
            ],
            'slug'
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
        $instance->processingSave($values);
        $instance->save();
        return $instance;
    }

    /**
     * @param $values
     */
    public function processingSave($values)
    {
        if (!empty($values['name'])) {
            $slug = str_slug($values['name']);
            $checkSlug = $this->query()->where(['slug'=>$slug])->where('id', '!=', $this->id)->get()->count();
            $i = 1;
            while ($checkSlug > 0) {
                $slug = $slug . $i;
                $checkSlug = $this->query()->where(['slug'=>$slug])->where('id', '!=', $this->id)->get()->count();
                $i++;
            }
            $this->attributes['slug'] = $slug;
        }
    }
}
