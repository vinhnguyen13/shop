<?php

namespace App\Models\Backend;

use App\Helpers\Grid;
use App\Models\ShopCategory as MainShopCategory;
use App\Services\ImageService;
use App\Services\UploadMedia;
use DB;

class ShopCategory extends MainShopCategory
{
    /**
     * @return Grid
     */
    public function gridIndex()
    {
        $query = DB::table('shop_category AS a');
        $grid = new Grid($query, [
            'id',
            'name' => [
                'label' => 'Name',
                'filter' => 'like',
            ],
            'status' => [
            ],
            'updated_at' => [
                'filter' => false,
            ],
        ]);
        return $grid;
    }

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
        if (!empty($values['images'])) {
            $instance->saveImages($values['images']);
        }
        $instance->save();
        return $instance;
    }

}
