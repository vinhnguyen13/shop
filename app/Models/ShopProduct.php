<?php

namespace App\Models;

use App\Models\Traits\HasValidator;
use App\Services\ImageService;
use App\Services\UploadMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use DB;

class ShopProduct extends Model
{
    use HasValidator;
    protected $table = 'shop_product';
    protected $fillable = ['supplier_id', 'sku_producer', 'name', 'description', 'location', 'stock_in', 'stock_out', 'stock_status_id', 'image', 'manufacturer_id', 'shipping', 'price', 'color', 'points', 'tax_class_id', 'date_available', 'weight', 'weight_class_id', 'length', 'width', 'height', 'length_class_id', 'order', 'status'];

    const uploadFolder = 'products';
    const TYPE_IMAGE = 'image';
    const TYPE_DISCOUNT = 'discount';
    const TYPE_SPECIAL = 'special';
    const TYPE_DETAIL = 'detail';

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
            'sku_producer' => 'required',
            'description' => 'required',
            'points' => 'numeric|min:0',
        ];
    }

    public function images(){
        return $this->hasMany(ShopProductImage::class, 'product_id')->orderBy('order');
    }

    public function manufacturer(){
        return $this->hasOne(ShopManufacturer::class, 'id', 'manufacturer_id');
    }

    public function details(){
        return $this->hasMany(ShopProductDetail::class, 'product_id');
    }

    public function tax(){
        return $this->hasOne(ShopTaxClass::class, 'id', 'tax_class_id');
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
        $url = '/images/default-shoes.png';
        $imageService = app(ImageService::class);
        $propertyMedia = app(ShopProduct::class)->propertyMedias();
        $imageService->setSize($propertyMedia['sizes']);
        $folder = $imageService->folder($size);
        if(app(ImageService::class)->exists($this->folder.DS.$folder.DS.$this->image)){
            $url = Storage::url($this->folder.DS.$folder.DS.$this->image);
        }
        return $url;
    }

    public function getDetailsGroupBySupplier(){
        $details = ShopProductDetail::query()->select([
            DB::raw('count(*) AS total'),
            DB::raw('CONCAT(supplier_id, "-", size, "-", new_status) AS `group_name`'),
            'id',
            'size',
            'supplier_id',
            'price_in',
            'price',
            'new_status',
        ])
            ->where(['product_id'=>$this->id])->groupBy(DB::raw("group_name"))->orderBy('size')->get();
        return $details;
    }

    public function getDetailsGroupBySize(){
        $details = ShopProductDetail::query()->select([
            DB::raw('count(*) AS total'),
            'id',
            'size',
            'supplier_id',
            'price_in',
            'price',
            'new_status',
        ])
            ->where(['product_id'=>$this->id])->groupBy(DB::raw("size"))->orderBy('size')->get();
        return $details;
    }

}
