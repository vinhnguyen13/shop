<?php

namespace App\Models\Frontend;

use App\Models\User as MainUser;

class User extends MainUser
{
    public function loginBySocial($userSocial, $provider){
        if(empty($userSocial)){
            return ['code'=>1, 'message'=>['user'=>trans('user.login.social_account_not_found')]];
        }
        if(!empty($provider)){
            switch($provider){
                case SocialAccount::PROVIDER_FACEBOOK:
                    $input = [
                        'email' => $userSocial->email,
                        'name' => $userSocial->name,
                    ];
                    $user = $this->updateData($input);
                    break;
                case SocialAccount::PROVIDER_GOOGLE:
                    $input = [
                        'email' => $userSocial->email,
                        'name' => $userSocial->name,
                    ];
                    $user = $this->updateData($input);
                    break;
            }
        }
        if(!empty($user->id)){
            $inputSocialAccount = [
                'user_id' => $user->id,
                'provider' => $provider,
                'client_id' => $userSocial->id,
                'data' => json_encode($userSocial->user),
            ];
            $socialAccount = app()->make(SocialAccount::class)->updateData($inputSocialAccount, $provider);
            if(!empty($user->id)) {
                return $user;
            }else{
                return ['code'=>1, 'message'=>$user];
            }
        }else{
            return ['code'=>1, 'message'=>['user'=>trans('user.login.social_account_not_found')]];
        }
    }

    /**
     * Login by email, password
     * @param $email
     * @param $password
     * @return array
     */
    public function login($email, $password){
        $user = User::query()->where('email', $email)->orWhere('username', $email)->first();
        if(empty($user)){
            return ['code'=>1, 'message'=>['email'=>trans('user.login.account_not_found')]];
        }
        if( !empty($user) &&  \Hash::check( $password, $user->getAuthPassword()) !== false) {
            // Password is matching
            \Auth::guard('web')->login($user);
            return ['code'=>0, 'message'=>trans('user.login.success')];
        } else {
            // Password is not matching
            return ['code'=>1, 'message'=>['password'=>trans('user.login.pass_not_match')]];
        }
        /*if (\Auth::attempt(['email' => $email, 'password' => $password])) {
                    return redirect()->intended('/');
                }*/
        /*$chk = Auth::loginUsingId(1);;
        Auth::guard('web')->user()*/
    }

}
