<?php

namespace App\Models;

use App\Models\Traits\HasValidator;
use Illuminate\Database\Eloquent\Model;
use App\Services\Payment;

class ShopOrder extends Model
{
    use HasValidator;
    protected $table = 'shop_order';
    protected $fillable = ['invoice_code', 'billing_name', 'billing_address', 'billing_country_id', 'billing_city_id', 'billing_district_id', 'billing_ward_id', 'billing_phone', 'billing_tax_code', 'shipping_name', 'shipping_address', 'shipping_country_id', 'shipping_city_id', 'shipping_district_id', 'shipping_ward_id', 'shipping_phone', 'payment_method', 'payment_method_id', 'payment_code', 'shipper_id', ''];

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
            'total_price' => 'required',
            'total' => 'required',
        ];
    }

    public function seller()
    {
        return $this->hasOne(User::class, 'id', 'seller_id');
    }

    public function customer()
    {
        return $this->hasOne(ShopCustomer::class, 'id', 'customer_id');
    }

    public function paymentMethod()
    {
        return $this->hasOne(ShopPayment::class, 'id', 'payment_method_id');
    }

    public function orderProducts()
    {
        return ShopOrderProduct::query()->where(['order_id'=>$this->id])->get();
    }

    public function orderDetails()
    {
        return ShopOrderDetail::query()->where(['order_id'=>$this->id])->get();
    }

    public function updateStatus($status)
    {
        if($status == ShopOrderStatus::STT_COMPLETE){
            $totalOrderProduct = ShopOrderProduct::query()->where(['order_id' => $this->id])->count();
            $flag = true;
            if(empty($totalOrderProduct)) {
                $orderDetails = ShopOrderDetail::query()->where(['order_id' => $this->id])->get();
                if (!empty($orderDetails)) {
                    foreach ($orderDetails as $orderDetail) {
                        $product = ShopProduct::find($orderDetail->product_id);
                        $totalDetail = $product->countDetailsBySize($orderDetail->size);
                        if ($orderDetail->quantity > $totalDetail) {
                            $flag = false;
                        }
                    }
                }
            }
            if($flag == true){
                $this->order_status_id = $status;
                $this->save();
                app(Payment::class)->processingSaveOrderProduct($this);
            }
        }else{
            $this->order_status_id = $status;
            $this->save();
        }
    }

}
