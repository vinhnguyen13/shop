<?php

namespace App\Models;

use App\Services\ImageService;
use App\Services\UploadMedia;
use Illuminate\Database\Eloquent\Model;

class ShopCategory extends Model
{
    protected $table = 'shop_category';
    protected $fillable = ['parent_id', 'name', 'description', 'image', 'status', 'order'];

    const uploadFolder = 'categories';
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot() {
        parent::boot();
        static::saving(function($model) {
            foreach($model->attributes as $key => $value) {
                if($value === '') {
                    unset($model->attributes[$key]);
//                    $model->{$key} = null;
                }
            }

        });
    }

    public function propertyMedias($folder = null)
    {
        $sizes = [
            'large' => [960, 720, 'resize'],
            'medium' => [480, 360, 'crop'],
            'thumb' => [240, 180, 'crop'],
        ];
        if(empty($folder)){
            $folder = uniqid();
        }
        return [
            'sizes'=>$sizes,
            'folderTmp'=>$folder,
            'pathReal'=>app(UploadMedia::class)->getPathDay(self::uploadFolder.DS),
            'pathTmp'=>app(UploadMedia::class)->getPathDay(self::uploadFolder.DS.'temp'.DS.$folder.DS),
        ];
    }

    public function saveImages($images)
    {
        if ($images) {
            $image = $images[0];
            $newPath = app(UploadMedia::class)->getPathDay(self::uploadFolder.DS);
            $path = pathinfo($image);
            $this->attributes['image'] = $path['basename'];
            $this->attributes['folder'] = $newPath;
            app(ImageService::class)->moveWithSize($path['dirname'], $newPath, $path['basename']);
        }
    }
}
