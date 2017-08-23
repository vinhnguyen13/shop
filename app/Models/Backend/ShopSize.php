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
                'label' => 'Category',
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
            'name',
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
        ]);
        return $grid;
    }
}
