<?php

namespace App\Models;

use App\Models\Traits\HasValidator;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ShopProductDetail extends Model
{
    use HasValidator;
    protected $table = 'shop_product_detail';
    protected $fillable = ['product_id', 'supplier_id', 'stock_status_id', 'sku', 'color' , 'size','price_in', 'price', 'new_status', 'condition', 'consignment_fee', 'stock_in_date', 'stock_in_type', 'stock_in_note', 'stock_out_date', 'stock_out_type', 'stock_out_note', 'debt_status'];

    const SPLIT_CODE = '-';

    const STOCK_IN_STOCK = 1;
    const STOCK_PRE_ORDER = 2;
    const STOCK_OUT_OF_STOCK = 3;
    const STOCK_SOME_DAYS = 4;

    const DEBT_START = 0;
    const DEBT_PENDING = 1;
    const DEBT_DUE_DATE = 2;
    const DEBT_PAID = 3;
    const DEBT_PROBLEM = 4;

    const DUE_DAYS = 4;

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
            'supplier_id' => 'required',
            'sku' => 'required|unique:shop_product_detail,sku',
            'size' => 'required',
            'price' => 'required',
            'new_status' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'supplier_id.required' => 'Detail >> Supplier is required',
            'size.required' => 'Detail >> Size is required',
            'price.required' => 'Detail >> Price is required',
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

    public function getStockStatus($id = null)
    {
        $data = [
            self::STOCK_IN_STOCK => trans('In Stock'),
            self::STOCK_PRE_ORDER => trans('Pre Order'),
            self::STOCK_OUT_OF_STOCK => trans('Out Of Stock'),
            self::STOCK_SOME_DAYS => trans('Some Days'),
        ];

        if (isset($data[$id])) {
            return $data[$id];
        } else {
            return $data;
        }
    }

    public function getDebtStatus($id = null)
    {
        $data = [
//            self::DEBT_START => trans('Start'),
            self::DEBT_PENDING => trans('Pending'),
            self::DEBT_DUE_DATE => trans('Payment Due Date'),
            self::DEBT_PAID => trans('Paid'),
            self::DEBT_PROBLEM => trans('Problem'),
        ];

        if (isset($data[$id])) {
            return $data[$id];
        } else {
            return $data;
        }
    }

    public function getTextNewStatus()
    {
        if($this->new_status == 1){
            return 'New';
        }
        return 'Used';
    }

    public function inStock(){
        return $this->stock_status_id === self::STOCK_IN_STOCK;
    }

    public function getPrice(){
        if(!empty($this->price)){
            return $this->price;
        }
        return false;
    }

    public function generateSKU(){
        $count = $this->query()->where(['product_id'=>$this->product_id, 'supplier_id'=>$this->supplier_id, 'size'=>$this->size, 'new_status'=>$this->new_status])->count();
        if(empty($this->sku)){
            $time = date('dmYH');
            $supplier = !empty($this->supplier->code) ? $this->supplier->code : null;
            $sku_producer = !empty($this->product->sku_producer) ? $this->product->sku_producer : null;
            $size = $this->size;
            $index = str_pad($count + 1, 2, '0', STR_PAD_LEFT);
            $splitCode = self::SPLIT_CODE;
            $this->sku = $time.$splitCode.$supplier.$splitCode.$sku_producer.$splitCode.$size.$splitCode.$index;
        }
    }

    public function isOrdered(){
        $exist = ShopOrderProduct::query()->where(['product_detail_id'=>$this->id])->exists();
        if(!empty($exist)){
            return true;
        }
        return false;
    }

    public function updateStockOut(){
        $this->fill([
            'stock_status_id'=>ShopProductDetail::STOCK_OUT_OF_STOCK,
            'stock_out_date'=>Carbon::now(),
            'debt_status'=>ShopProductDetail::DEBT_PENDING,
        ]);
    }

    public function updateStockIn(){
        $this->fill([
            'stock_status_id'=>ShopProductDetail::STOCK_IN_STOCK,
            'stock_in_date'=>Carbon::now(),
            'debt_status'=>ShopProductDetail::DEBT_START,
        ]);
    }
}
