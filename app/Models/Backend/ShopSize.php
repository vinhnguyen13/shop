<?php

namespace App\Models\Backend;

use App\Models\ShopSize as MainShopSize;
use App\Helpers\Grid;
use App\Models\ShopSizeCategory;
use App\Models\ShopSizeLocales;
use App\Models\ShopSizePerson;
use DB;

class ShopSize extends MainShopSize
{
    public function gridIndex(){
        $query = DB::table('shop_size AS a');
        $grid = new Grid($query, [
            'id',
            'category_id' => [
                'label' => 'Product Category',
                'format' => function($item){
                    $item = ShopCategory::find($item->category_id);
                    $html = '';
                    if(!empty($item->id)){
                        $html = $item->name;
                    }
                    return $html;
                }
            ],
            'size_person_id' => [
                'label' => 'Person Type',
                'format' => function($item){
                    $item = ShopSizePerson::find($item->size_person_id);
                    $html = '';
                    if(!empty($item->id)){
                        $html = $item->name;
                    }
                    return $html;
                }
            ],
            'manufacturer_id' => [
                'label' => 'Manufacturer',
                'format' => function($item){
                    $item = ShopManufacturer::find($item->manufacturer_id);
                    $html = '';
                    if(!empty($item->id)){
                        $html = $item->name;
                    }
                    return $html;
                }
            ],
            'size_locales_id' => [
                'label' => 'Locales',
                'format' => function($item){
                    $item = ShopSizeLocales::find($item->size_locales_id);
                    $html = '';
                    if(!empty($item->id)){
                        $html = $item->name;
                    }
                    return $html;
                }
            ],
            'size_category_id' => [
                'label' => 'Size Category',
                'format' => function($item){
                    $item = ShopSizeCategory::find($item->size_category_id);
                    $html = '';
                    if(!empty($item->id)){
                        $html = $item->name;
                    }
                    return $html;
                }
            ],
            'value',
            'status' => [
                'label' => 'Status',
                'format' => function($item){
                    $item = self::find($item->id);
                    $html = '';
                    if(!empty($item->id)){
                        $html = $item->getStatus($item->status);
                    }
                    return $html;
                }
            ],
            'custom_column' => [
                'custom' => true,
                'label' => 'Action',
                'format' => function($item) {
                    $uri = \Request::route()->getUri();
                    $show = link_to(url("$uri/show", [$item->id]), '', ['class' => 'glyphicon glyphicon-eye-open', 'data-toggle' => 'tooltip', 'data-original-title' => 'View']);
                    $edit = link_to(url("$uri/edit", [$item->id]), '', ['class' => 'glyphicon glyphicon-pencil', 'data-toggle' => 'tooltip', 'data-original-title' => 'Delete']);
                    return $show.$edit;
                }
            ]
        ]);
        $grid->removeActionColumn();
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

    }
}
