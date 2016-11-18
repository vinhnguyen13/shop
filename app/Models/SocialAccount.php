<?php
/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 9/26/2016
 * Time: 6:04 PM
 */

namespace App\Models;

use App\Models\Traits\HasValidator;
use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{
    use HasValidator;
    protected $table = 'social_account';
    protected $fillable =  ['id', 'user_id', 'provider', 'client_id', 'data', 'code', 'created_at', 'email', 'username'];
    protected $primaryKey = 'id';
    public $timestamps = false;

    const PROVIDER_FACEBOOK = 'facebook';
    const PROVIDER_GOOGLE = 'google';

    public function rules()
    {
        return [
            'user_id' => 'required',
            'provider' => 'required',
            'client_id' => 'required',
        ];
    }

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    /**
     * Create, update social account
     * @param $input
     * @return User|\Illuminate\Support\MessageBag
     */
    public function updateData($input){
        $socialAccount = $this->query()->where(['client_id'=>$input['client_id']])->first();
        if(!empty($socialAccount)){
            $attributes = array_collapse([[
            ], $input]);
        }else{
            $socialAccount = new SocialAccount();
            $attributes = array_collapse([[
                'created_at' => time(),
            ], $input]);
        }
        $socialAccount->fill($attributes);
        $validate = $socialAccount->validate($socialAccount->attributes);
        if($validate->passes()){
            $socialAccount->save();
            return $socialAccount;
        }else{
            return $validate->getMessageBag();
        }
    }
}