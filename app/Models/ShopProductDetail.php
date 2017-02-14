<?php

namespace App\Models;

use App\Models\Traits\HasValidator;
use Illuminate\Database\Eloquent\Model;

class ShopProductDetail extends Model
{
    use HasValidator;
    protected $table = 'shop_product_detail';
    protected $fillable = ['product_id', 'supplier_id', 'sku', 'color' , 'size','price_in', 'price', 'new_status'];
    public $timestamps = false;

    const SPLIT_CODE = '-';

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
            'product_id' => 'required',
            'size' => 'required',
            'new_status' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'size.required' => 'Size tab >> Size is required',
        ];
    }

    public function product()
    {
        return $this->hasOne('App\Models\ShopProduct', 'id', 'product_id');
    }

    public function supplier()
    {
        return $this->hasOne('App\Models\ShopSupplier', 'id', 'supplier_id');
    }

    public function getPrice(){
        if(!empty($this->price)){
            return $this->price;
        }
        return $this->product->getPrice();
    }

    public function generateSKU(){
        $count = $this->query()->where(['supplier_id'=>$this->supplier_id, 'size'=>$this->size, 'new_status'=>$this->new_status])->count();
        if(empty($this->sku)){
            $time = date('dmYH');
            $supplier = $this->supplier->code;
            $sku_producer = $this->product->sku_producer;
            $size = $this->size;
            $index = str_pad($count + 1, 2, '0', STR_PAD_LEFT);
            $splitCode = self::SPLIT_CODE;
            $this->sku = $time.$splitCode.$supplier.$splitCode.$sku_producer.$splitCode.$size.$splitCode.$index;
        }
    }
}
