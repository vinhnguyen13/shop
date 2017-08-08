<?php

namespace App\Models;

use App\Models\Traits\HasValidator;
use App\Services\ImageService;
use App\Services\UploadMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use DB;

class ShopSize extends Model
{
    use HasValidator;
    protected $table = 'shop_size';
    protected $fillable = ['supplier_id', 'sku_producer', 'name', 'description', 'location', 'stock_in', 'stock_out', 'stock_status_id', 'image', 'manufacturer_id', 'shipping', 'price', 'color', 'points', 'tax_class_id', 'date_available', 'weight', 'weight_class_id', 'length', 'width', 'height', 'length_class_id', 'order', 'status'];

    const uploadFolder = 'products';
    const TYPE_IMAGE = 'image';
    const TYPE_DISCOUNT = 'discount';
    const TYPE_SPECIAL = 'special';
    const TYPE_DETAIL = 'detail';

    const STATUS_DELETE = -1;
    const STATUS_ACTIVE = 1;

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
            'sku_producer' => 'required|unique:shop_product,sku_producer,'.$this->id,
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

    public function getDetailsAvailable(){
        $details = ShopProductDetail::query()->where(['product_id'=>$this->id, 'stock_status_id'=>ShopProductDetail::STOCK_IN_STOCK])->orderBy('created_at', 'DESC')->get();
        return $details;
    }

    public function getDetailsGroupBySize(){
        $sub = ShopProductDetail::query()->where(['product_id'=>$this->id, 'stock_status_id'=>ShopProductDetail::STOCK_IN_STOCK])->orderBy('created_at', 'ASC');
        $details = ShopProductDetail::query()->select([
            'id',
            'product_id',
            'size',
            'supplier_id',
            'price_in',
            'price',
            'new_status',
        ])->from(DB::raw("(".$sub->toSql().") as `sub`"))
            ->mergeBindings($sub->getQuery())
            ->groupBy(DB::raw("size"))->orderBy('size')->get();
        return $details;
    }

    public function getDetailsForCheckout($limit = 1)
    {
        $details = ShopProductDetail::query()->where(['product_id' => $this->id, 'stock_status_id' => ShopProductDetail::STOCK_IN_STOCK])->orderBy('created_at', 'ASC')->limit($limit)->get();
        return $details;
    }

    public function getPriceDefault($size = null, $direction = 'asc'){
        $price = 0;
        $productDetailDefault = $this->getDetailDefault($size, $direction = 'asc');
        if(!empty($productDetailDefault)){
            $price = $productDetailDefault->price;
        }
        return $price;
    }

    public function getDetailDefault($size = null, $direction = 'asc')
    {
        $query = ShopProductDetail::query()->where(['product_id'=>$this->id]);
        if(!empty($size)){
            $query->where(['size'=>$size]);
        }
        $query->orderBy('price', $direction);
        return $query->first();
    }

    public function getDetailsBySize($size, $quantity, $direction = 'asc')
    {
        $details = ShopProductDetail::query()->where(['product_id' => $this->id, 'size'=>$size, 'stock_status_id' => ShopProductDetail::STOCK_IN_STOCK])->orderBy('created_at', $direction)->limit($quantity)->get();
        return $details;
    }

    public function countDetailsBySize($size)
    {
        $details = ShopProductDetail::query()->where(['product_id' => $this->id, 'size'=>$size, 'stock_status_id' => ShopProductDetail::STOCK_IN_STOCK])->count();
        return $details;
    }

    public function updateStockByIds($ids){
        if(!empty($ids)){
            foreach($ids as $id){
                $product = self::find($id);
                $product->updateStock();
            }
        }
    }

    public function updateStock(){
        $stock_in = ShopProductDetail::query()->where(['product_id'=>$this->id, 'stock_status_id'=>ShopProductDetail::STOCK_IN_STOCK])->count();
        $stock_in_count = $stock_in ? $stock_in : 0;
        $stock_out = ShopProductDetail::query()->where(['product_id'=>$this->id, 'stock_status_id'=>ShopProductDetail::STOCK_OUT_OF_STOCK])->count();
        $stock_out_count = $stock_out ? $stock_out : 0;
        $this->update([
            'stock_in'=>$stock_in_count,
            'stock_out'=>$stock_out_count
        ]);
    }

    public function getSizes(){
        $query = ShopProductDetail::query()->groupBy('size');
        return $query->pluck('size', 'id');
    }
}
