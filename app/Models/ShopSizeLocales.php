<?php

namespace App\Models;

use App\Models\Traits\HasValidator;
use Illuminate\Database\Eloquent\Model;
use DB;

class ShopSizeLocales extends Model
{
    use HasValidator;
    protected $table = 'shop_size_locales';
    protected $fillable = ['code', 'name'];
}
