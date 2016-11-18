<?php

namespace App\Models;

use App\Models\Traits\HasValidator;
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
        ];
    }

    /**
     * @param $input
     */
    public function profile(){
        return $this->hasOne('App\Models\UserProfile', 'user_id', 'id');
    }

}
