<?php
/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 11/10/2016
 * Time: 10:27 AM
 */

namespace App\Services;


use App\Models\ShopCategory;
use App\Models\ShopProduct;
use Illuminate\Support\Facades\Input;
use Storage;

class UploadMedia
{
    const UPLOAD_PRODUCT = 'product';
    const UPLOAD_CATEGORY = 'category';
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
                $response = [
                    'name' => $name,
                    'url' => Storage::url($pathFolder ."/". $name),
                    'deleteUrl' => route('admin.deleteTempFile', ['_token' => csrf_token(), 'name' => $name, 'type' => $type, 'folder' => $folder]),
                    'thumbnailUrl' => Storage::url($pathFolder ."/". $imageService->folder('thumb') . "/" . $name),
                    'deleteType' => 'DELETE',
                    'input' => [
                        'name' => 'images[]',
                        'value' => $pathFolder ."/". $name
                    ]
                ];

                return ['files' => [$response]];
            }
        }
        return false;
    }

    /**
     * @param $request
     * @param $type
     * @return array
     */
    public function deleteTempFile($request, $type)
    {
        if (!empty($type)) {
            $folder = $request->get('folder');
            $propertyMedia = $this->getPropertyMediaWithType($type, $folder);
            $pathFolder = $propertyMedia['pathTmp'];
            $imageService = app(ImageService::class);
            $imageService->setSize($propertyMedia['sizes']);
            $name = Input::get('name');
            if (!empty($pathFolder) && $name) {
                $res = $imageService->deleteWithSize($pathFolder, $name);
                return ['delete_file' => $res];
            }
            return [];
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
            $propertyMedia = $this->getPropertyMediaWithType($type, $folder);
            $pathFolder = $propertyMedia['pathReal'];
            $imageService = app(ImageService::class);
            $imageService->setSize($propertyMedia['sizes']);
            $name = Input::get('name');
            if (!empty($pathFolder) && $name) {
                $res = $imageService->deleteWithSize($pathFolder, $name);
                return ['delete_file' => $res];
            }
            return [];
        }
        return false;
    }


}