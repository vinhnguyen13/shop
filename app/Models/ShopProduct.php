<?php

namespace App\Models;

use App\Models\Traits\HasValidator;
use App\Services\ImageService;
use App\Services\UploadMedia;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ShopProduct extends Model
{
    use HasValidator;
    protected $table = 'shop_product';
    protected $fillable = ['supplier_id', 'sku', 'name', 'description', 'location', 'quantity', 'stock_status_id', 'image', 'manufacturer_id', 'shipping', 'price', 'points', 'tax_class_id', 'date_available', 'weight', 'weight_class_id', 'length', 'width', 'height', 'length_class_id', 'subtract', 'minimum', 'order', 'status'];

    const uploadFolder = 'products';
    const TYPE_IMAGE = 'image';
    const TYPE_DISCOUNT = 'discount';
    const TYPE_SPECIAL = 'special';

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            foreach ($model->attributes as $key => $value) {
                if ($value === '') {
                    unset($model->attributes[$key]);
//                    $model->{$key} = null;
                }
            }

        });
    }

    public function rules()
    {
        return [
            'quantity' => 'required',
            'price' => 'required|numeric|min:2',
            'points' => 'numeric|min:0',
        ];
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
        $validate = $instance->validate($instance->attributes, $instance->rules());
        $instance->processingImages($values);
        $instance->processingDiscount($values);
        $instance->processingSpecial($values);
        $instance->processingCategory($values);
        if ($validate->passes()) {
            $instance->save();
            return $instance;
        } else {
            return $validate->getMessageBag();
        }
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
        } else {

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
    }

    public function processingDiscount($values)
    {
        if (!empty($values['product_discount'])) {
            foreach ($values['product_discount'] as $key => $value) {
                $date_start = !empty($value['date_start']) ? $value['date_start'] : date('d/m/Y');
                $date_end = !empty($value['date_end']) ? $value['date_end'] : date('d/m/Y');
                $productDiscount = ShopProductDiscount::query()->where(['id'=>$key])->first();
                if(empty($productDiscount)){
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
                $validate = $productDiscount->validate($productDiscount->attributes, $productDiscount->rules());
                if ($validate->passes()) {
                    $productDiscount->save();
                } else {
                    $err[] = $validate->getMessageBag();
                }

            }
        }
    }

    public function processingSpecial($values)
    {
        if (!empty($values['product_special'])) {
            foreach ($values['product_special'] as $key => $value) {
                $date_start = !empty($value['date_start']) ? $value['date_start'] : date('d/m/Y');
                $date_end = !empty($value['date_end']) ? $value['date_end'] : date('d/m/Y');
                $productSpecial = ShopProductSpecial::query()->where(['id'=>$key])->first();
                if(empty($productSpecial)){
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
                $validate = $productSpecial->validate($productSpecial->attributes, $productSpecial->rules());
                if ($validate->passes()) {
                    $productSpecial->save();
                } else {
                    $err[] = $validate->getMessageBag();
                }
            }
        }
    }

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

    /**
     * @param null $folder
     * @return array
     */
    public function propertyMedias($folder = null)
    {
        $sizes = [
            'large' => [960, 720, 'resize'],
            'medium' => [480, 360, 'crop'],
            'thumb' => [240, 180, 'crop'],
        ];
        if (empty($folder)) {
            $folder = uniqid();
        }
        return [
            'sizes' => $sizes,
            'folderTmp' => $folder,
            'pathReal' => app(UploadMedia::class)->getPathDay(self::uploadFolder . DS),
            'pathTmpNotDay' => self::uploadFolder . DS . UploadMedia::TEMP_FOLDER . DS . $folder . DS,
            'pathTmp' => app(UploadMedia::class)->getPathDay(self::uploadFolder . DS . UploadMedia::TEMP_FOLDER . DS . $folder . DS),
        ];
    }


}
