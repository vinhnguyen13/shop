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
        $categories = app(ShopCategory::class)->gridIndex();
        return view('category.index', compact('categories'));
    }

    public function create(Request $request)
    {
        $model = new ShopCategory();
        return view('category.form', compact('model', 'image'));
    }

    public function show(Request $request, $id)
    {
        $model = ShopCategory::find($id);
        return view('category.view', compact('model'));
    }

    public function edit(Request $request, $id)
    {
        $model = ShopCategory::find($id);
        if(!empty($model)) {
            $image = $model->getImages();
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