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
            'sku' => 'required',
            'description' => 'required',
            'price' => 'required|numeric|min:2',
            'points' => 'numeric|min:0',
        ];
    }

    public function images(){
        return $this->hasMany(ShopProductImage::class, 'product_id')->orderBy('order');
    }

    public function manufacturer(){
        return $this->hasOne(ShopManufacturer::class, 'id', 'manufacturer_id');
    }

    public function sizes(){
        return $this->hasMany(ShopProductDetail::class, 'product_id');
    }

    public function tax(){
        return $this->hasOne(ShopTaxClass::class, 'id', 'tax_class_id');
    }

    public function setCart($sizeID, $quantity){
        $this->size = ShopProductDetail::find($sizeID);
        $this->quantity = $quantity;
    }

    public function size(){
        return !empty($this->size) ? $this->size->size : '';
    }

    public function taxWithPrice($price){
        if(!empty($this->tax)){
            if($this->tax->type == ShopTaxClass::TYPE_FLAT){
                return $this->tax->rate;
            }elseif($this->tax->type == ShopTaxClass::TYPE_PERCEN){
                return ($this->tax->rate / 100) * $price;
            }
        }
        return 0;
    }

    public function getPrice(){
        return $this->price;
    }

    public function priceSpecial(){
        return $this->price;
    }

    public function priceWithSize(){
        if(!empty($this->size)){
            $size = $this->size;
        }
        if(!empty($size)) {
            $price = $size->getPrice();
        }else{
            $price = $this->getPrice();
        }
        return $price;
    }

    public function categoriesName(){
        return '';
    }

    /**
     * @param null $folder
     * @return array
     */
    public function propertyMedias($folder = null)
    {
        $sizes = [
            'large' => [960, 960, 'resize'],
            'medium' => [480, 480, 'resize'],
            'thumb' => [240, 240, 'resize'],
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

    /**
     * @return \Illuminate\Foundation\Application|mixed
     */
    public function getImageService(){
        $imageService = app(ImageService::class);
        $propertyMedia = $this->propertyMedias();
        $imageService->setSize($propertyMedia['sizes']);
        return $imageService;
    }

    public function url()
    {
        $url = route('product.detail', ['id'=>$this->id, 'slug'=>str_slug($this->name)]);
        return $url;

    }

    public function thumb($size = 'medium')
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
