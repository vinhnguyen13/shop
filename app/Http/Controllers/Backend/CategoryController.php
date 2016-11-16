<?php
/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 4/19/2016
 * Time: 11:27 AM
 */
namespace App\Http\Controllers\Backend;

use App\Models\Backend\ShopCategory;
use App\Services\ImageService;
use App\Services\UploadMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Storage;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $grid = app(ShopCategory::class)->gridIndex();
        if ($request->ajax()) {
            return $grid->table();
        }else{
            return view('category.index', compact('grid'));
        }
    }

    public function create(Request $request)
    {
        $model = new ShopCategory();
        return view('category.form', compact('model', 'image'));
    }

    public function edit(Request $request, $id)
    {
        $model = ShopCategory::find($id);
        if(!empty($model)) {
            if($model->image && app(ImageService::class)->exists($model->folder .DS. $model->image)) {
                $image[] = app(UploadMedia::class)->loadImages(
                    $model->image,
                    Storage::url($model->folder .DS. $model->image),
                    route('admin.deleteFile', ['_token' => csrf_token(), 'name' => $model->image, 'type' => UploadMedia::UPLOAD_CATEGORY, 'delete'=>UploadMedia::DELETE_REAL]),
                    Storage::url($model->folder .DS. app(ImageService::class)->folder('thumb') . DS . $model->image),
                    'DELETE',
                    'imagesReal[]',
                    $model->folder .DS. $model->image
                );
            }else{
                $image = null;
            }
            return view('category.form', compact('model', 'image'));
        }else
            return abort(404, 'Not Found');
    }

    public function store(Request $request)
    {
        $input = Input::all();
        $return = app(ShopCategory::class)->updateOrCreate(['id'=>$input['id']], $input);
        if(!empty($return->id)){
            return Redirect::route('admin.category.index');
        }else{
            return Redirect::back();
        }
    }

    public function delete(Request $request, $id)
    {
        $model = ShopCategory::find($id);
        if(!empty($model)) {
            $model->delete();
        }
        return Redirect::route('admin.category.index');
    }

    public function getList(Request $request){

        $cancha = $request->input('term');
        $categories = ShopCategory::all();
        $result = [];
        foreach ($categories as $category) {
            $result[] = [ 'id' => $category->id, 'value' => $category->name ];;
        }
        return $result;
    }

}