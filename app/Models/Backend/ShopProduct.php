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
use Storage;
use DB;
use Carbon\Carbon;

class ShopProduct extends MainShopProduct
{
    private $errors = [];

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
        $validate = $instance->validate($instance->attributes);
        $instance->processingProduct($values);
        if ($validate->passes()) {
            $instance->save();
            $instance->processingImages($values);
            $instance->processingDiscount($values);
            $instance->processingSpecial($values);
            $instance->processingSize($values);
            $instance->processingCategory($values);
        } else {
            return $validate->getMessageBag();
        }

        if(!empty($instance->errors)){
//                $messageBag = new \Illuminate\Support\MessageBag();
            $messageBag = $validate->getMessageBag();
            foreach($instance->errors as $error){
                $messageBag->merge($error->getMessages());
            }
            return $validate->getMessageBag();
        }
        return $instance;
    }

    /**
     * @param $values
     */
    public function processingProduct($values)
    {
        if (!empty($values['date_available'])) {
            $this->attributes['date_available'] = Carbon::createFromFormat('d/m/Y', $values['date_available'])->format('Y-m-d');
        }
        $this->attributes['quantity'] = 0;
    }
    /**
     * @param $images
     */
    public function processingImages($values)
    {
        if (!empty($values['images'])) {
            foreach ($values['images'] as $key => $image) {
                $image = $image[0];
                if (app(ImageService::class)->exists($image)) {
                    $newPath = app(UploadMedia::class)->getPathDay(self::uploadFolder . DS);
                    $path = pathinfo($image);
                    app(ImageService::class)->moveWithSize($path['dirname'], $newPath, $path['basename']);
                    $folders = explode(DS, $path['dirname']);
                    app(ImageService::class)->deleteDirectory(self::uploadFolder . DS . UploadMedia::TEMP_FOLDER . DS . $folders[2]);
                    $productImage = new ShopProductImage();
                    $productImage->fill([
                        'product_id' => $this->id,
                        'image' => $path['basename'],
                        'folder' => str_replace(DS . UploadMedia::TEMP_FOLDER . DS . $folders[2], '', $path['dirname']),
                        'order' => !empty($values['orderImage'][$key][0]) ? $values['orderImage'][$key][0] : 0,
                        'uploaded_at' => Carbon::now(),
                    ])->save();
                }
            }
        }
        if (!empty($values['orderImage'])) {
            foreach ($values['orderImage'] as $key => $value) {
                $productImage = ShopProductImage::query()->where(['id' => $key])->first();
                if(!empty($productImage)){
                    $productImage->attributes['order'] = $value[0];
                    $productImage->save();
                }
            }
        }
        $imageDefault = ShopProductImage::query()->where(['product_id' => $this->id])->orderBy('order', 'asc')->first();
        if (!empty($imageDefault)) {
            $this->attributes['image'] = $imageDefault->image;
            $this->attributes['folder'] = $imageDefault->folder;
        } else {
            $this->attributes['image'] = null;
            $this->attributes['folder'] = null;
        }
        $this->update();
        return true;
    }

    /**
     * @param $values
     * @return bool
     */
    public function processingDiscount($values)
    {
        if (!empty($values['product_discount'])) {
            foreach ($values['product_discount'] as $key => $value) {
                $date_start = !empty($value['date_start']) ? $value['date_start'] : date('d/m/Y');
                $date_end = !empty($value['date_end']) ? $value['date_end'] : date('d/m/Y');
                if(!empty($value['id'])) {
                    $productDiscount = ShopProductDiscount::query()->where(['id' => $value['id']])->first();
                }else{
                    $productDiscount = new ShopProductDiscount();
                }
                $productDiscount->fill([
                    'product_id'=>$this->id,
                    'customer_group_id'=>$value['customer_group_id'],
                    'quantity'=>$value['quantity'],
                    'priority'=>$value['priority'],
                    'price'=>$value['price'],
                    'date_start'=>Carbon::createFromFormat('d/m/Y', $date_start)->format('Y-m-d'),
                    'date_end'=>Carbon::createFromFormat('d/m/Y', $date_end)->format('Y-m-d'),
                ]);
                $validate = $productDiscount->validate($productDiscount->attributes);
                if ($validate->passes()) {
                    $productDiscount->save();
                } else {
                    $this->errors[] = $validate->getMessageBag();
                }

            }
        }
        return true;
    }

    /**
     * @param $values
     * @return bool
     */
    public function processingSpecial($values)
    {
        if (!empty($values['product_special'])) {
            foreach ($values['product_special'] as $key => $value) {
                $date_start = !empty($value['date_start']) ? $value['date_start'] : date('d/m/Y');
                $date_end = !empty($value['date_end']) ? $value['date_end'] : date('d/m/Y');
                if(!empty($value['id'])){
                    $productSpecial = ShopProductSpecial::query()->where(['id'=>$value['id']])->first();
                }else{
                    $productSpecial = new ShopProductSpecial();
                }
                $productSpecial->fill([
                    'product_id'=>$this->id,
                    'customer_group_id'=>$value['customer_group_id'],
                    'priority'=>$value['priority'],
                    'price'=>$value['price'],
                    'date_start'=>Carbon::createFromFormat('d/m/Y', $date_start)->format('Y-m-d'),
                    'date_end'=>Carbon::createFromFormat('d/m/Y', $date_end)->format('Y-m-d'),
                ]);
                $validate = $productSpecial->validate($productSpecial->attributes);
                if ($validate->passes()) {
                    $productSpecial->save();
                } else {
                    $this->errors[] = $validate->getMessageBag();
                }
            }
        }
        return true;
    }

    /**
     * @param $values
     * @return bool
     */
    public function processingSize($values)
    {
        if (!empty($values['product_size'])) {
            foreach ($values['product_size'] as $key => $value) {
                if(!empty($value['id'])){
                    $productSize = ShopProductSize::query()->where(['id'=>$value['id']])->first();
                }else{
                    $productSize = new ShopProductSize();
                }
                $productSize->fill([
                    'product_id'=>$this->id,
                    'size'=>$value['size'],
                    'quantity'=>$value['quantity'],
                    'price'=>$value['price'],
                    'new_status'=>$value['new_status']/100,
                ]);
                $validate = $productSize->validate($productSize->attributes);
                if ($validate->passes()) {
                    $this->attributes['quantity'] += $value['quantity'];
                    $productSize->save();
                } else {
                    $this->errors[] = $validate->getMessageBag();
//                    $this->errors[] = $validate->messages()->toArray();
                }
            }
        }
        $this->update();
        return true;
    }

    /**
     * @param $values
     */
    public function processingCategory($values){
        if (!empty($values['category'])) {
            ShopProductCategory::query()->where(['product_id' => $this->id])->delete();
            foreach ($values['category'] as $catid) {
                $productCategory = new ShopProductCategory();
                $productCategory->fill([
                    'product_id' => $this->id,
                    'category_id' => $catid
                ])->save();
            }
        }
    }

    /**
     * @param $type
     * @param $id
     * @return bool|mixed|null
     * @throws \Exception
     */
    public function deleteReference($type, $id)
    {
        if(!empty($type)){
            switch($type){
                case self::TYPE_DISCOUNT:
                    $model = ShopProductDiscount::query()->where(['id'=>$id])->first();
                    break;
                case self::TYPE_SPECIAL:
                    $model = ShopProductSpecial::query()->where(['id'=>$id])->first();
                    break;
                case self::TYPE_IMAGE:
                    $model = ShopProductImage::query()->where(['id'=>$id])->first();
                    break;
            }
            if(!empty($model)){
                return $model->delete();
            }
        }
        return false;
    }
}
