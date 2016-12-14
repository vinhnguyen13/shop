<?php

namespace App\Models;

use App\Models\Traits\HasValidator;
use App\Services\ImageService;
use App\Services\UploadMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ShopProduct extends Model
{
    use HasValidator;
    protected $table = 'shop_product';
    protected $fillable = ['supplier_id', 'sku', 'name', 'description', 'location', 'quantity', 'stock_status_id', 'image', 'manufacturer_id', 'shipping', 'price', 'color', 'points', 'tax_class_id', 'date_available', 'weight', 'weight_class_id', 'length', 'width', 'height', 'length_class_id', 'subtract', 'minimum', 'order', 'status'];

    const uploadFolder = 'products';
    const TYPE_IMAGE = 'image';
    const TYPE_DISCOUNT = 'discount';
    const TYPE_SPECIAL = 'special';
    const TYPE_SIZE = 'size';

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
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric|min:2',
            'points' => 'numeric|min:0',
        ];
    }

    public function images(){
        return $this->hasMany(ShopProductImage::class, 'product_id')->orderBy('order');
    }

    public function sizes(){
        return $this->hasMany(ShopProductSize::class, 'product_id');
    }

    public function price(){
        return $this->price;
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

    public function url($size = 'medium')
    {
        $url = '/images/default-shoes.jpg';
        $imageService = app(ImageService::class);
        $propertyMedia = app(ShopProduct::class)->propertyMedias();
        $imageService->setSize($propertyMedia['sizes']);
        $folder = $imageService->folder($size);
        if(app(ImageService::class)->exists($this->folder.DS.$folder.DS.$this->image)){
            $url = Storage::url($this->folder.DS.$folder.DS.$this->image);
        }
        return $url;
    }

}
