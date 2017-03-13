<?php
/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 4/19/2016
 * Time: 11:27 AM
 */
namespace App\Http\Controllers\Backend;

use App\Models\UserProfile;
use App\Models\Backend\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Input;
use Storage;
use Redirect;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $grid = app(User::class)->gridUser();
        if ($request->ajax()) {
            return $grid->table();
        }else{
            return view('user.index', compact('grid'));
        }
    }

    public function create(Request $request)
    {
        $user = new User();
        return view('user.form', compact('user'));
    }

    public function edit(Request $request, $id)
    {
        $user = User::find($id);
        $profile = $user->profile()->first();
        $image = $user->getImagesToForm();
        if(!empty($user))
            return view('user.form', compact('user', 'profile', 'image'));
        else
            return abort(404, 'Not Found');
    }

    public function store(Request $request)
    {
        $input = Input::all();
        $return = app(User::class)->updateOrCreate(['id'=>$input['id']], $input);
        if(!empty($return->id)){
            return Redirect::route('admin.user.index');
        }else{
            return Redirect::back()->withErrors($return);
        }
    }

    public function show(Request $request, $id)
    {
        $user = User::find($id);
        $profile = $user->profile()->first();
        if(!empty($user))
            return view('user.view', compact('user', 'profile'));
        else
            return abort(404, 'Not Found');
    }

    public function delete(Request $request)
    {
        if ($request->ajax()) {
            return '';
        }else{
            return view('user.index', compact('grid'));
        }
    }

    public function deleteFile() {
        $name = Input::get('name');
        if($name) {
            $path = UserProfile::uploadAvatarFolder. "/" . $name;
            $thumb_path = UserProfile::uploadAvatarFolder. "/thumb_" . $name;
            $visibility_path = Storage::disk('public')->exists($path);
            $res1 = false;
            if($visibility_path)
                $res1 = Storage::disk('public')->delete($path);
            $res2 = false;
            $visibility_thumb_path = Storage::disk('public')->exists($thumb_path);
            if($visibility_thumb_path)
                $res2 = Storage::disk('public')->delete($thumb_path);

            return ['delete_file' => $res1, 'delete_thumb_file' => $res2];
        }
        return [];
    }

    public function uploadAvatar()
    {
        if($file = Input::file('avatar')) {
            $name = uniqid() . '.' . $file->getClientOriginalExtension();
            $image = Image::make($file);
            $path = UserProfile::uploadAvatarFolder. "/temp/". $name;
            Storage::disk('public')->put($path, $image->stream());

            $thumb_name = "thumb_". $name;
            $thumb_image = $image->resize(150, 150);
            $thumb_path = UserProfile::uploadAvatarFolder. "/temp/". $thumb_name;
            Storage::disk('public')->put($thumb_path, $thumb_image->stream());
            $response = [
                'name' => $name,
                'url' => Storage::url(UserProfile::uploadAvatarFolder. "/temp/". $name),
                'deleteUrl' => route('user.deleteTempFile', ['_token' => csrf_token(), 'name' => $name]),
                'thumbnailUrl' => Storage::url(UserProfile::uploadAvatarFolder. "/temp/". $thumb_name),
                'deleteType' => 'DELETE',
                'input' => [
                    'name' => 'avatar[]',
                    'value' => $name
                ]
            ];

            return ['files' => [$response]];
        }
        return ['files' => 'upload failed'];
    }

    public function deleteTempFile() {
        $name = Input::get('name');
        if($name) {
            $path = UserProfile::uploadAvatarFolder. "/temp/" . $name;
            $thumb_path = UserProfile::uploadAvatarFolder. "/temp/thumb_" . $name;
            $visibility_path = Storage::disk('public')->exists($path);
            $res1 = false;
            if($visibility_path)
                $res1 = Storage::disk('public')->delete($path);
            $res2 = false;
            $visibility_thumb_path = Storage::disk('public')->exists($thumb_path);
            if($visibility_thumb_path)
                $res2 = Storage::disk('public')->delete($thumb_path);

            return ['delete_file' => $res1, 'delete_thumb_file' => $res2];
        }
        return [];
    }

    public function verify(Request $request)
    {
        $input = Input::all();
        if ($request->ajax()) {
            $user = User::query()->where('email', $input['email'])->first();
            if( !empty($user->id) &&  \Hash::check( $input['password'], $user->getAuthPassword()) !== false) {
                // Password is matching
                return ['code'=>0, 'message'=>trans('user.login.success')];
            }else{
                return ['code'=>1, 'message'=>trans('auth.failed')];
            }
        }
        return ['code'=>1, 'message'=>trans('user.login.not_success')];;
    }

}