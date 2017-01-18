<?php
/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 11/10/2016
 * Time: 11:54 AM
 */

namespace App\Services;

use Image;
use Storage;

class ImageService
{
    public $disk;
    public $sizes = [
        'large' => [960, 960, 'resize'],
        'medium' => [480, 480, 'crop'],
        'thumb' => [240, 240, 'crop'],
    ];

    /**
     * __construct
     */
    public function __construct()
    {
        $this->disk = Storage::disk('public');
    }

    /**
     * @param $size
     * @return string
     */
    public function folder($size)
    {
        $sizes = $this->getSize();
        $wh = $sizes[$size];
        return "{$wh[0]}x{$wh[1]}";
    }

    /**
     * @return \Illuminate\Filesystem\FilesystemAdapter
     */
    public function getDisk()
    {
        return $this->disk;
    }

    /**
     * @return array
     */
    public function getSize()
    {
        return $this->sizes;
    }

    /**
     * @param $sizes
     */
    public function setSize($sizes)
    {
        $this->sizes = $sizes;
    }

    /**
     * @param $path
     * @param $file
     * @param $name
     */
    public function putWithSize($path, $file, $name)
    {
        $image = Image::make($file);
        $this->disk->put($path . DIRECTORY_SEPARATOR . $name, $image->stream());
        $this->path = $path;
        $this->name = $name;
        $sizes = $this->getSize();
        if (!empty($sizes)) {
            foreach ($sizes as $size => $wh) {
                $filePath = $path . DIRECTORY_SEPARATOR . $this->folder($size) . DIRECTORY_SEPARATOR . $name;
                call_user_func(array($this, $wh[2]), $filePath, $image, $wh[0], $wh[1]);
            }
        }
    }

    /**
     * @param $oldPath
     * @param $newPath
     * @param $name
     */
    public function moveWithSize($oldPath, $newPath, $name)
    {
        $this->disk->move($oldPath . DIRECTORY_SEPARATOR . $name, $newPath . DIRECTORY_SEPARATOR . $name);
        $sizes = $this->getSize();
        if (!empty($sizes)) {
            foreach ($sizes as $size => $wh) {
                $f = DIRECTORY_SEPARATOR . self::folder($size) . DIRECTORY_SEPARATOR;
                $this->disk->move($oldPath . $f . $name, $newPath . $f . $name);
            }
        }
    }

    /**
     * @param $path
     * @param $name
     */
    public function deleteWithSize($path, $name)
    {
        $this->disk->delete($path . DIRECTORY_SEPARATOR . $name);
        $sizes = $this->getSize();
        if (!empty($sizes)) {
            foreach ($sizes as $size => $wh) {
                $this->delete($path . DIRECTORY_SEPARATOR . self::folder($size) . DIRECTORY_SEPARATOR . $name);
            }
        }
        return true;
    }

    public function deleteDirectory($path)
    {
        return $this->disk->deleteDirectory($path);
    }

    /**
     * @param $filePath
     * @param $image
     * @param $width
     * @param $height
     */
    public function crop($filePath, $image, $width, $height)
    {
        $this->disk->put($filePath, $image->fit($width, $height)->stream());
    }

    /**
     * @param $filePath
     * @param $image
     * @param $width
     * @param $height
     */
    public function resize($filePath, $image, $width, $height)
    {
        $this->disk->put($filePath, $image->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
            // $constraint->upsize();
        })->stream());
    }

    /**
     * @param $path
     * @param $contents
     * @param null $visibility
     */
    public function put($path, $contents, $visibility = null)
    {
        $this->disk->put($path, $contents, $visibility);
    }

    /**
     * @param $path
     * @return bool
     */
    public function delete($path)
    {
        if ($this->disk->exists($path)) {
            $this->disk->delete($path);
        }
        return false;
    }

    public function exists($path)
    {
        return $this->disk->exists($path);
    }
}