<?php

namespace App\Models\Backend;
use App\Helpers\Grid;
use App\Models\User as MainUser;
use App\Services\ImageService;
use App\Services\UploadMedia;
use Illuminate\Support\Facades\Storage;
use DB;

/**
 * App\Modules\Backend\Models\User
 *
 * @mixin \Eloquent
 */
class User extends MainUser
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
     * @param $input
     */
    public function updateOrCreate(array $attributes, array $values = []){
        $instance = $this->firstOrNew($attributes);
        $instance->fill($values);
        $validate = $instance->validate($instance->attributes);
        $instance->processingUser($values);
        if ($validate->passes()) {
            $instance->save();
            $instance->processingProfile($values);
        } else {
            return $validate->getMessageBag();
        }
        if(!empty($instance->errors)){
            $messageBag = $validate->getMessageBag();
            foreach($instance->errors as $error){
                $messageBag->merge($error->getMessages());
            }
            return $validate->getMessageBag();
        }
        return $instance;
    }

    /**
     * @param $values
     */
    public function processingUser($values)
    {

    }

    /**
     * @param $values
     */
    public function processingProfile($values)
    {
        if (!empty($values['images'])) {
            foreach ($values['images'] as $key => $image) {
                $image = $image[0];
                if (app(ImageService::class)->exists($image)) {
                    $newPath = app(UploadMedia::class)->getPathDay(UserProfile::uploadFolder . DS);
                    $path = pathinfo($image);
                    app(ImageService::class)->moveWithSize($path['dirname'], $newPath, $path['basename']);
                    $folders = explode(DS, $path['dirname']);
                    app(ImageService::class)->deleteDirectory(UserProfile::uploadFolder . DS . UploadMedia::TEMP_FOLDER . DS . $folders[2]);
                    $profile = app(UserProfile::class)->firstOrNew(['user_id' => $this->id]);
                    $profile->fill([
                        'avatar' => $path['basename'],
                        'folder' => str_replace(DS . UploadMedia::TEMP_FOLDER . DS . $folders[2], '', $path['dirname']),
                    ])->save();
                }
                break;
            }
        }
    }

    /**
     * @return array
     */
    public function getImagesToForm(){
        $profile = UserProfile::query()->where(['user_id'=>$this->id])->first();
        $imageList = [];
        if(!empty($profile)){
            $name = $profile->avatar;
            $folder = $profile->folder;
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