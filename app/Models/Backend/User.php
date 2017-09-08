<?php

namespace App\Models\Backend;
use App\Helpers\Grid;
use App\Models\User as Model;
use App\Services\ImageService;
use App\Services\UploadMedia;
use Illuminate\Support\Facades\Storage;
use DB;

/**
 * App\Modules\Backend\Models\User
 *
 * @mixin \Eloquent
 */
class User extends Model
{
    public function gridUser(){
        $query = DB::table('users AS a');
        $grid = new Grid($query, [
            'id',
            'name' => [
                'label' => 'Name',
                'filter' => 'like',
            ],
            'email' => [
                'filter' => 'like',
            ],
            'created_at'=> [
                'label'=>'Registration Time',
            ],
        ]);
        return $grid;
    }

    /**
     * @return array
     */
    public function getImages(){
        $profile = UserProfile::query()->where(['user_id'=>$this->id])->first();
        $imageList = [];
        $imageService = $this->getImageService();
        if(!empty($profile)){
            $name = $profile->avatar;
            $folder = $profile->folder;
            $imageList[] = app(UploadMedia::class)->loadImages(
                $name,
                Storage::url($folder .DS. $name),
                route('admin.deleteFile', ['_token' => csrf_token(), 'name' => $name, 'type' => UploadMedia::UPLOAD_PRODUCT, 'delete'=>UploadMedia::DELETE_REAL]),
                'DELETE',
                $this->id,
                Storage::url($folder .DS. $imageService->folder('thumb') . DS . $name),
                ['name'=>'imagesReal['.$this->id.'][]', 'value'=>$folder .DS. $name],
                null
            );
        }
        return $imageList;
    }

}