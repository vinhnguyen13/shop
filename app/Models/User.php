<?php

namespace App\Models;

use App\Models\Traits\HasValidator;
use App\Services\ImageService;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use Notifiable, HasValidator;
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function rules()
    {
        return [
            'email' => 'required|email|unique:users,email,'.$this->id,
            'password' => 'required|min:6',
        ];
    }

    /**
     * @param $input
     */
    public function profile(){
        return $this->hasOne('App\Models\UserProfile', 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Foundation\Application|mixed
     */
    public function getImageService(){
        $imageService = app(ImageService::class);
//        $propertyMedia = $this->propertyMedias();
//        $imageService->setSize($propertyMedia['sizes']);
        return $imageService;
    }

    public function verify($email, $password){
        $user = User::query()->where('email', $email)->orWhere('username', $email)->first();
        if( !empty($user->id) &&  \Hash::check( $password, $user->getAuthPassword()) !== false) {
            return $user;
        }else{
            return false;
        }
    }

}
