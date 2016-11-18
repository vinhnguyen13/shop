<?php

namespace App\Models\Backend;

use App\Helpers\Grid;
use App\Models\ShopCategory as MainShopCategory;
use App\Services\ImageService;
use App\Services\UploadMedia;
use DB;
use Storage;

class ShopCategory extends MainShopCategory
{
    /**
     * @return Grid
     */
    public function gridIndex()
    {
        $query = DB::table('shop_category AS a');
        $grid = new Grid($query, [
            'id',
            'name' => [
                'label' => 'Name',
                'filter' => 'like',
            ],
            'slug',
            'status' => [
            ],
            'updated_at' => [
                'filter' => false,
            ],
        ]);
        return $grid;
    }

    /**
     * Create or update a related record matching the attributes, and fill it with values.
     *
     * @param  array $attributes
     * @param  array $values
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function updateOrCreate(array $attributes, array $values = [])
    {
        $instance = $this->firstOrNew($attributes);
        $instance->fill($values);
        $instance->processingCategory($values);
        $instance->save();
        $instance->processingImages($values);
        return $instance;
    }

    /**
     * @param $values
     */
    public function processingCategory($values)
    {
        if (!empty($values['name'])) {
            $this->attributes['slug'] = str_slug($values['name']);
        }
    }

    /**
     * @param $images
     */
    public function processingImages($values)
    {
        if (!empty($values['images'])) {
            foreach ($values['images'] as $key => $image) {
                $image = $image[0];
                if (app(ImageService::class)->exists($image)) {
                    $newPath = app(UploadMedia::class)->getPathDay(self::uploadFolder . DS);
                    $path = pathinfo($image);
                    $this->attributes['image'] = $path['basename'];
                    $this->attributes['folder'] = $newPath;
                    app(ImageService::class)->moveWithSize($path['dirname'], $newPath, $path['basename']);
                    $folders = explode(DS, $path['dirname']);
                    app(ImageService::class)->deleteDirectory(self::uploadFolder . DS . UploadMedia::TEMP_FOLDER . DS . $folders[2]);
                }
            }
            $this->update();
        }
    }

    public function getImagesToForm(){
        $imageList = [];
        if(!empty($this->image)){
            $name = $this->image;
            $folder = $this->folder;
            $imageList[] = app(UploadMedia::class)->loadImages(
                $name,
                Storage::url($folder .DS. $name),
                route('admin.deleteFile', ['_token' => csrf_token(), 'name' => $name, 'type' => UploadMedia::UPLOAD_PRODUCT, 'delete'=>UploadMedia::DELETE_REAL]),
                'DELETE',
                $this->id,
                Storage::url($folder .DS. app(ImageService::class)->folder('thumb') . DS . $name),
                ['name'=>'imagesReal['.$this->id.'][]', 'value'=>$folder .DS. $name],
                null
            );
        }
        return $imageList;
    }
}
