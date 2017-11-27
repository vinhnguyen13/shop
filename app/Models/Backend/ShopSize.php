<?php

namespace App\Models\Backend;

use App\Models\ShopSize as Model;
use App\Helpers\Grid;
use App\Models\ShopSizeCategory;
use App\Models\ShopSizeLocales;
use App\Models\ShopSizePerson;
use DB;

class ShopSize extends Model
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
            'value' => [
                'label' => 'Value',
                'format' => function($item){
                    $html = ''; 
                    if(!empty($item->size_category_id)){
                        $itemCategory = ShopSizeCategory::find($item->size_category_id);
                        if(!empty($itemCategory->id)){
                            $html = $itemCategory->name;
                        }
                        $html .= !empty($item->value) ? ' ('.$item->value.')' : '';
                    }else{
                        $html = $item->value;
                    }
                    return $html;
                }
            ],
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
        $grid->setHiddenColumn(['size_category_id']);
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
        $validate = $instance->validate($instance->attributes);
        $instance->processingSave($values);
        if ($validate->passes()) {
            $instance->save();
            return $instance;
        }else{
            return $validate->getMessageBag();
        }
    }

    /**
     * @param $values
     */
    public function processingSave($values)
    {

    }
}
