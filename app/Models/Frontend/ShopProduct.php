<?php

namespace App\Models\Frontend;

use App\Helpers\Grid;
use App\Models\ShopCategory;
use App\Models\ShopProduct as MainShopProduct;
use DB;

class ShopProduct extends MainShopProduct
{
    public function getList($params = array()){
        $query = ShopProduct::from('shop_product AS a');
        $query->where(['status'=>1]);
        if(!empty($params['category'])){
            $category = ShopCategory::query()->where(['slug'=>$params['category']])->first();
            if(!empty($category)){
                $query->join('shop_product_category AS b', function ($join) use ($category){
                    $join->on('a.id', '=', 'b.product_id')->where(['b.category_id'=>$category->id]);
                });
            }
        }
        $products = $query->limit($params['limit'])->orderBy('updated_at', 'DESC')->get();
        return $products;
    }
}
