<?php

namespace App\Models;

use App\Services\ImageService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ShopProductImage extends Model
{
    protected $table = 'shop_product_image';
    protected $fillable = ['product_id', 'image', 'folder', 'order', 'uploaded_at'];
    public $timestamps = false;

    public function url($size = 'medium')
    {
        $url = '/images/default-shoes.jpg';
        $imageService = app(ShopProduct::class)->getImageService();
        $file = $imageService->folder($size).DS.$this->image;
        if($size == 'original'){
            $file = $this->image;
        }
        if($imageService->exists($this->folder.DS.$file)){
            $url = Storage::url($this->folder.DS.$file);
        }
        return $url;
    }
}
