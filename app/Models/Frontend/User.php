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

}
