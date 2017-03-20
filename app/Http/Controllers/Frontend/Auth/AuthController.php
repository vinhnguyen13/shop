<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Models\Frontend\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Contracts\Factory as Socialite;
use Validator;
use App\Http\Controllers\Frontend\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */

    public function __construct(Socialite $socialite){
        $this->middleware('guest', ['except' => ['logout']]);
        $this->socialite = $socialite;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    public function logout(Request $request)
    {
        if (\Auth::guard('web')->check()) {
            \Auth::guard('web')->logout();
        }
        return Redirect::back();
    }

    public function getSocialAuth(Request $request, $provider=null){
        if(!config("services.$provider")) abort('404'); //just to handle providers that doesn't exist

        return $this->socialite->with($provider)->redirect();
    }

    public function getSocialAuthCallback(Request $request, $provider=null){
        if($userSocial = $this->socialite->with($provider)->user()){
            $user = app()->make(User::class)->loginBySocial($userSocial, $provider);
            if(!empty($user)){
                $return = \Auth::loginUsingId($user->id);
                if(!empty($return)){
                    return Redirect::to('/');
                }else{
                    return view('auth.login')->withErrors($return['message']);
                }
            }
        }else{
            return 'something went wrong';
        }
    }
}
