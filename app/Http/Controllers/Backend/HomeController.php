<?php
/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 4/19/2016
 * Time: 11:27 AM
 */
namespace App\Http\Controllers\Backend;

use App\Models\Backend\ShopProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Image;
use Storage;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home.index', ['content' => PHP_EOL . \Illuminate\Foundation\Inspiring::quote() . PHP_EOL]);
    }

    public function demo()
    {
        return view('demo', ['content' => PHP_EOL . \Illuminate\Foundation\Inspiring::quote() . PHP_EOL]);
    }

    public function upload(Request $request, $type)
    {
        if ($type == 'product') {
            $pathFolder = ShopProduct::uploadFolder . "/temp/";
        }
        if ($file = Input::file('image')) {
            $name = uniqid() . '.' . $file->getClientOriginalExtension();
            $image = Image::make($file);
            $path = $pathFolder . $name;
            Storage::disk('public')->put($path, $image->stream());

            $thumb_name = "thumb_" . $name;
            $thumb_image = $image->resize(150, 150);
            $thumb_path = $pathFolder . $thumb_name;
            Storage::disk('public')->put($thumb_path, $thumb_image->stream());
            $response = [
                'name' => $name,
                'url' => Storage::url($pathFolder . $name),
                'deleteUrl' => route('admin.deleteTempFile', ['_token' => csrf_token(), 'name' => $name, 'type' => $type]),
                'thumbnailUrl' => Storage::url($pathFolder . $thumb_name),
                'deleteType' => 'DELETE',
                'input' => [
                    'name' => 'images[]',
                    'value' => $name
                ]
            ];

            return ['files' => [$response]];
        }
        return ['files' => 'upload failed'];
    }

    public function deleteTempFile(Request $request, $type)
    {
        if ($type == 'product') {
            $pathFolder = ShopProduct::uploadFolder . "/temp/";
        }
        $name = Input::get('name');
        if ($name) {
            $path = $pathFolder . $name;
            $thumb_path = $pathFolder . "thumb_" . $name;
            $visibility_path = Storage::disk('public')->exists($path);
            $res1 = false;
            if ($visibility_path)
                $res1 = Storage::disk('public')->delete($path);
            $res2 = false;
            $visibility_thumb_path = Storage::disk('public')->exists($thumb_path);
            if ($visibility_thumb_path)
                $res2 = Storage::disk('public')->delete($thumb_path);

            return ['delete_file' => $res1, 'delete_thumb_file' => $res2];
        }
        return [];
    }

    public function deleteFile(Request $request, $type)
    {
        if ($type == 'product') {
            $pathFolder = ShopProduct::uploadFolder . "/";
        }
        $name = Input::get('name');
        if ($name) {
            $path = $pathFolder . $name;
            $thumb_path = $pathFolder . "thumb_" . $name;
            $visibility_path = Storage::disk('public')->exists($path);
            $res1 = false;
            if ($visibility_path)
                $res1 = Storage::disk('public')->delete($path);
            $res2 = false;
            $visibility_thumb_path = Storage::disk('public')->exists($thumb_path);
            if ($visibility_thumb_path)
                $res2 = Storage::disk('public')->delete($thumb_path);

            return ['delete_file' => $res1, 'delete_thumb_file' => $res2];
        }
        return [];
    }
}