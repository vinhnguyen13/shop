<?php

namespace App\Models\Backend;

use App\Helpers\Grid;
use App\Models\ShopCategory as MainShopCategory;
use App\Models\ShopCategoryParent;
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
        $instance->processingSave($values);
        $instance->save();
        $instance->processingCategoryParent($values);
        $instance->processingImages($values);
        return $instance;
    }

    /**
     * @param $values
     */
    public function processingSave($values)
    {
        if (!empty($values['name'])) {
            $slug = str_slug($values['name']);
            $checkSlug = $this->query()->where(['slug'=>$slug])->where('id', '!=', $this->id)->get()->count();
            $i = 1;
            while ($checkSlug > 0) {
                $slug = $slug . $i;
                $checkSlug = $this->query()->where(['slug'=>$slug])->where('id', '!=', $this->id)->get()->count();
                $i++;
            }
            $this->attributes['slug'] = $slug;
        }
    }

    /**
     * @param $values
     */
    public function processingCategoryParent($values)
    {
        if (!empty($values['parent'])) {
            ShopCategoryParent::query()->where(['category_id' => $this->id])->delete();
            foreach($values['parent'] as $parent_id){
                $productCategory = new ShopCategoryParent();
                $productCategory->fill([
                    'category_id' => $this->id,
                    'parent_id' => $parent_id
                ])->save();
            }
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

    public function getImages(){
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

    public function getCategories(){
        $categories = ShopCategoryParent::query()->where(['category_id'=>$this->id])->get();
        $return = [];
        if(!empty($categories)){
            foreach ($categories as $category)
            {
                $return[] = $category->parent_id;
            }
        }
        return $return;
    }
}
