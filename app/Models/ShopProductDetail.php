<?php

namespace App\Models;

use App\Models\Traits\HasValidator;
use Illuminate\Database\Eloquent\Model;

class ShopProductDetail extends Model
{
    use HasValidator;
    protected $table = 'shop_product_detail';
    protected $fillable = ['product_id', 'size', 'quantity', 'price', 'new_status'];
    public $timestamps = false;

    public function rules()
    {
        return [
            'product_id' => 'required',
            'size' => 'required',
            'quantity' => 'digits_between:1,5',
            'new_status' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'size.required' => 'Size tab >> Size is required',
            'quantity.numeric' => 'Size tab >> Quantity must be between 1 and 5 digits.',
        ];
    }

    public function product()
    {
        return $this->hasOne('App\Models\ShopProduct', 'id', 'product_id');
    }

    public function getPrice(){
        if(!empty($this->price)){
            return $this->price;
        }
        return $this->product->getPrice();
    }
}
