<?php

namespace App\Models;

use App\Models\Traits\HasValidator;
use App\Services\ImageService;
use App\Services\UploadMedia;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;


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
        'username', 'name', 'email', 'password',
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
            'username' => 'required|unique:users,username,'.$this->id,
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
    /**
     * @param $input
     */
    public function updateOrCreate(array $attributes, array $values = []){
        if(!empty($attributes)){
            $instance = $this->query()->where($attributes)->first();
        }else{
            $instance = $this->firstOrNew($attributes);
        }
        $instance->fill($values);
        $instance->processingUser($values);
        $validate = $instance->validate($instance->attributes);
        if ($validate->passes()) {
            $instance->save();
            $instance->processingProfile($values);
        } else {
            return $validate->getMessageBag();
        }
        if(!empty($instance->errors)){
            $messageBag = $validate->getMessageBag();
            foreach($instance->errors as $error){
                $messageBag->merge($error->getMessages());
            }
            return $validate->getMessageBag();
        }
        return $instance;
    }

    /**
     * @param $values
     */
    public function processingUser($values)
    {
        if(!empty($values['password'])){
            $this->password = \Hash::make($values['password']);
        }
        $this->username = $this->generateUsername($values['email']);
        $this->remember_token = Str::random(60);
    }

    /**
     * @param $values
     */
    public function processingProfile($values)
    {
        $profile = app(UserProfile::class)->firstOrCreate(['user_id' => $this->id]);
        if (!empty($values['images'])) {
            $imageService = $this->getImageService();
            foreach ($values['images'] as $key => $image) {
                $image = $image[0];
                if ($imageService->exists($image)) {
                    $newPath = app(UploadMedia::class)->getPathDay(UserProfile::uploadFolder . DS);
                    $path = pathinfo($image);
                    $imageService->moveWithSize($path['dirname'], $newPath, $path['basename']);
                    $folders = explode(DS, $path['dirname']);
                    $imageService->deleteDirectory(UserProfile::uploadFolder . DS . UploadMedia::TEMP_FOLDER . DS . $folders[2]);
                    $profile->fill([
                        'avatar' => $path['basename'],
                        'folder' => str_replace(DS . UploadMedia::TEMP_FOLDER . DS . $folders[2], '', $path['dirname']),
                    ])->save();
                }
                break;
            }
        }
    }
    /**
     * Generate username
     * @return $this
     */
    public function generateUsername($email)
    {
        // try to use name part of email
        $username = $usernameFirst = explode('@', $email)[0];
        $rules = $this->rules();
        $v = \Validator::make(['username'=>$usernameFirst], ['username'=>$rules['username']]);
        $i = 1;
        while (!$v->passes()) {
            $username = $usernameFirst . $i;
            $v = \Validator::make(['username'=>$username], ['username'=>$rules['username']]);
            $i++;
        }
        return $username;
    }

}
