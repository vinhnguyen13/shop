<?php

namespace App\Models;

use App\Services\UploadMedia;
use Illuminate\Database\Eloquent\Model;
use Storage;

class UserProfile extends Model
{
    protected $table = 'user_profile';
    protected $fillable =  ['user_id', 'avatar', 'folder', 'phone', 'mobile', 'address'];

    public static $rules = [
        'user_id' => 'required',
    ];
    protected $primaryKey = 'user_id';
    public $timestamps = false;
    const uploadFolder = 'avatar';

    /**
     * @param null $folder
     * @return array
     */
    public function propertyMedias($folder = null)
    {
        $sizes = [
            'large' => [960, 960, 'resize'],
            'medium' => [480, 480, 'resize'],
            'thumb' => [240, 240, 'resize'],
        ];
        if (empty($folder)) {
            $folder = uniqid();
        }
        return [
            'sizes' => $sizes,
            'folderTmp' => $folder,
            'pathReal' => app(UploadMedia::class)->getPathDay(self::uploadFolder . DS),
            'pathTmpNotDay' => self::uploadFolder . DS . UploadMedia::TEMP_FOLDER . DS . $folder . DS,
            'pathTmp' => app(UploadMedia::class)->getPathDay(self::uploadFolder . DS . UploadMedia::TEMP_FOLDER . DS . $folder . DS),
        ];
    }

    public function avatarUrl()
    {
        $url = "/images/default-avatar.jpg";
        if(!empty($this->avatar) && Storage::disk('public')->exists('avatar/'. $this->avatar)){
            $url = Storage::url('avatar/'. $this->avatar);
        }
        return $url;
    }

}
