<?php
/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 4/19/2016
 * Time: 11:27 AM
 */
namespace App\Http\Controllers\Backend;

use App\Models\Profile;
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
        if($profile->avatar)
            $avatar[] = [
                'name' => $profile->avatar,
                'url' => Storage::url(Profile::uploadAvatarFolder. "/" . $profile->avatar),
                'deleteUrl' => route('user.deleteFile', ['_token' => csrf_token(), 'name' => $profile->avatar]),
                'thumbnailUrl' => Storage::url(Profile::uploadAvatarFolder . "/thumb_" . $profile->avatar),
                'deleteType' => 'DELETE',
                'input' => [
                    'name' => 'avatar[]',
                    'value' => $profile->avatar
                ]
            ];
        else
            $avatar = null;
        if(!empty($user))
            return view('user.form', compact('user', 'profile', 'avatar'));
        else
            return abort(404, 'Not Found');
    }

    public function store(Request $request)
    {
        $input = Input::all();
        $data = [
            'email'=> $request->input('email'),
            'password'=> $request->input('email'),
            'name'=> $request->input('name'),
        ];
        $return = app(User::class)->updateData($data);
        if(!empty($return->id)){
            return Redirect::route('user.index');
        }else{
            return Redirect::back();
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
            $path = Profile::uploadAvatarFolder. "/" . $name;
            $thumb_path = Profile::uploadAvatarFolder. "/thumb_" . $name;
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
            $path = Profile::uploadAvatarFolder. "/temp/". $name;
            Storage::disk('public')->put($path, $image->stream());

            $thumb_name = "thumb_". $name;
            $thumb_image = $image->resize(150, 150);
            $thumb_path = Profile::uploadAvatarFolder. "/temp/". $thumb_name;
            Storage::disk('public')->put($thumb_path, $thumb_image->stream());
            $response = [
                'name' => $name,
                'url' => Storage::url(Profile::uploadAvatarFolder. "/temp/". $name),
                'deleteUrl' => route('user.deleteTempFile', ['_token' => csrf_token(), 'name' => $name]),
                'thumbnailUrl' => Storage::url(Profile::uploadAvatarFolder. "/temp/". $thumb_name),
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
            $path = Profile::uploadAvatarFolder. "/temp/" . $name;
            $thumb_path = Profile::uploadAvatarFolder. "/temp/thumb_" . $name;
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

}