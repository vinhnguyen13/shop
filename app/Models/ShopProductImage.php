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
        $folder = $imageService->folder($size);
        if($imageService->exists($this->folder.DS.$folder.DS.$this->image)){
            $url = Storage::url($this->folder.DS.$folder.DS.$this->image);
        }
        return $url;
    }
}
