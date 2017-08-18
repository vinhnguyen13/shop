<?php

namespace App\Models;

use App\Models\Traits\HasValidator;
use Illuminate\Database\Eloquent\Model;
use DB;

class ShopSizeCategory extends Model
{
    use HasValidator;
    protected $table = 'shop_size_category';
    protected $fillable = ['code', 'name'];
}
