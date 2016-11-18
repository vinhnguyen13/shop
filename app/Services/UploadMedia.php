<?php
/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 11/10/2016
 * Time: 10:27 AM
 */

namespace App\Services;


use App\Models\Backend\ShopCategory;
use App\Models\Backend\ShopProduct;
use App\Models\Backend\UserProfile;
use Illuminate\Support\Facades\Input;
use Storage;

class UploadMedia
{
    const UPLOAD_PRODUCT = 'product';
    const UPLOAD_CATEGORY = 'category';
    const UPLOAD_AVATAR = 'avatar';

    const DELETE_TMP = 'tmp';
    const DELETE_REAL = 'real';
    const TEMP_FOLDER = 'temp';
    /**
     * @param null $path
     * @return null|string
     */
    public function getPathDay($path = null)
    {
        if (!empty($path)) {
            $path .= date('Y') . DIRECTORY_SEPARATOR . date('m') . DIRECTORY_SEPARATOR . date('d');
        }
        return $path;
    }

    /**
     * @param $type
     * @param $folder
     * @return array
     */
    public function getPropertyMediaWithType($type, $folder = null)
    {
        $propertyMedia = [];
        switch ($type) {
            case self::UPLOAD_PRODUCT:
                $propertyMedia = app(ShopProduct::class)->propertyMedias($folder);
                break;
            case self::UPLOAD_CATEGORY:
                $propertyMedia = app(ShopCategory::class)->propertyMedias($folder);
                break;
            case self::UPLOAD_AVATAR:
                $propertyMedia = app(UserProfile::class)->propertyMedias($folder);
                break;
        }
        return $propertyMedia;
    }

    /**
     * @param $request
     * @param $type
     * @return array
     */
    public function upload($request, $type)
    {
        if (!empty($type)) {
            $propertyMedia = $this->getPropertyMediaWithType($type);
            $folder = $propertyMedia['folderTmp'];
            $pathFolder = $propertyMedia['pathTmp'];
            $imageService = app(ImageService::class);
            $imageService->setSize($propertyMedia['sizes']);
            if (!empty($pathFolder) && $file = Input::file('image')) {
                $name = uniqid() . '.' . $file->getClientOriginalExtension();
                $imageService->putWithSize($pathFolder, $file, $name);
                $image[] = $this->loadImages(
                    $name,
                    Storage::url($pathFolder .DS. $name),
                    route('admin.deleteFile', ['_token' => csrf_token(), 'name' => $name, 'type' => UploadMedia::UPLOAD_CATEGORY, 'delete'=>UploadMedia::DELETE_TMP, 'folder' => $folder]),
                    'DELETE',
                    null,
                    Storage::url($pathFolder .DS. $imageService->folder('thumb') . DS . $name),
                    ['name'=>'images['.$name.'][]', 'value'=>$pathFolder .DS. $name],
                    ['name'=>'orderImage['.$name.'][]', 'value'=>'']

                );
                return ['files' => $image];
            }
        }
        return false;
    }

    /**
     * @param $request
     * @param $type
     * @return array
     */
    public function deleteFile($request, $type)
    {
        if (!empty($type)) {
            $folder = $request->get('folder');
            $name = $request->get('name');
            $delete = $request->get('delete');
            $propertyMedia = $this->getPropertyMediaWithType($type, $folder);
            $imageService = app(ImageService::class);
            $imageService->setSize($propertyMedia['sizes']);
            if($delete == self::DELETE_TMP){
                $pathFolder = $propertyMedia['pathTmpNotDay'];
                if (!empty($pathFolder) && $name) {
                    $res = $imageService->deleteDirectory($pathFolder);
                    return ['delete_file' => $res];
                }
            }elseif($delete == self::DELETE_REAL){
                $pathFolder = $propertyMedia['pathReal'];
                if (!empty($pathFolder) && $name) {
                    $res = $imageService->deleteWithSize($pathFolder, $name);
                    return ['delete_file' => $res];
                }
            }
            return [];
        }
        return false;
    }

    /**
     * @param $name
     * @param $url
     * @param $deleteUrl
     * @param $thumbnailUrl
     * @param string $deleteType
     * @param string $input_name
     * @param $input_value
     * @return array
     */
    public function loadImages($name, $url, $deleteUrl, $deleteType = 'DELETE', $imgId, $thumbnailUrl, $input, $order)
    {
        $return = [
            'name' => $name,
            'url' => $url,
            'deleteUrl' => $deleteUrl,
            'deleteType' => $deleteType,
            'imgId' => $imgId,
            'thumbnailUrl' => $thumbnailUrl,
            'input' => $input,
            'order' => $order,
        ];
        return $return;
    }


}