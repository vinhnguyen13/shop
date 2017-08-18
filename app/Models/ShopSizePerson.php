<?php

namespace App\Models;

use App\Models\Traits\HasValidator;
use Illuminate\Database\Eloquent\Model;
use DB;

class ShopSizePerson extends Model
{
    use HasValidator;
    protected $table = 'shop_size_person';
    protected $fillable = ['code', 'name'];
}
