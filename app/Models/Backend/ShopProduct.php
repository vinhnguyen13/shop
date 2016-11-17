<?php

namespace App\Models\Backend;

use App\Helpers\Grid;
use App\Models\ShopProduct as MainShopProduct;
use App\Models\ShopProductCategory;
use App\Models\ShopProductDiscount;
use App\Models\ShopProductImage;
use App\Models\ShopProductSize;
use App\Models\ShopProductSpecial;
use App\Services\ImageService;
use App\Services\UploadMedia;
use Image;
use Storage;
use DB;

class ShopProduct extends MainShopProduct
{
    public function gridIndex(){
        $query = DB::table('shop_product AS a');
        $grid = new Grid($query, [
            'id',
            'name' => [
                'label' => 'Name',
                'filter' => 'like',
            ],
            'sku',
            'price',
            'quantity',
            'status',
            'created_at',
        ]);
        return $grid;
    }

    public function getImagesToForm(){
        $images = ShopProductImage::query()->where(['product_id'=>$this->id])->orderBy('order', 'asc')->get();
        $imageList = [];
        if(!empty($images)){
            foreach($images as $image){
                $name = $image->image;
                $folder = $image->folder;
                $imageList[] = app(UploadMedia::class)->loadImages(
                    $name,
                    Storage::url($folder .DS. $name),
                    route('admin.deleteFile', ['_token' => csrf_token(), 'name' => $name, 'type' => UploadMedia::UPLOAD_PRODUCT, 'delete'=>UploadMedia::DELETE_REAL]),
                    'DELETE',
                    $image->id,
                    Storage::url($folder .DS. app(ImageService::class)->folder('thumb') . DS . $name),
                    ['name'=>'imagesReal['.$image->id.'][]', 'value'=>$folder .DS. $name],
                    ['name'=>'orderImage['.$image->id.'][]', 'value'=>$image->order]
                );
            }
        }
        return $imageList;
    }

    public function getDiscountToForm(){
        $discounts = ShopProductDiscount::query()->where(['product_id'=>$this->id])->orderBy('date_end', 'desc')->get();
        return $discounts;
    }

    public function getSpecialToForm(){
        $specials = ShopProductSpecial::query()->where(['product_id'=>$this->id])->orderBy('date_end', 'desc')->get();
        return $specials;
    }

    public function getSizeToForm(){
        $specials = ShopProductSize::query()->where(['product_id'=>$this->id])->get();
        return $specials;
    }

    public function getCategoriesToForm(){
        $categories = ShopProductCategory::query()->where(['product_id'=>$this->id])->get();
        if(!empty($categories)){
            $return = [];
            foreach ($categories as $category)
            {
                $return[] = $category->category_id;
            }
            return $return;
        }
    }
}
