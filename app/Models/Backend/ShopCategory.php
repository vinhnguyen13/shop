<?php

namespace App\Models\Backend;

use App\Models\ShopCategory as MainShopCategory;
use DB;
use App\Helpers\Grid;

class ShopCategory extends MainShopCategory
{
    const STATUS_DISABLE = 0;
    const STATUS_ENABLE = 1;

    /**
     * @param null $id
     * @return array
     */
    public static function statusLabel($id = null)
    {
        $data = [
            self::STATUS_ENABLE => 'Enable',
            self::STATUS_DISABLE => 'Disable',
        ];

        if ($id !== null && isset($data[$id])) {
            return $data[$id];
        } else {
            return $data;
        }
    }

    /**
     * @return Grid
     */
    public function gridIndex(){
        $query = DB::table('shop_category AS a');
        $grid = new Grid($query, [
            'id',
            'name' => [
                'label' => 'Name',
                'filter' => 'like',
            ],
            'status' => [
            ],
            'created_at'=> [
            ],
        ]);
        return $grid;
    }

    public function updateData($data){

    }

}
