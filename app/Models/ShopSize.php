<?php

namespace App\Models;

use App\Models\Traits\HasValidator;
use App\Services\ImageService;
use App\Services\UploadMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use DB;

class ShopSize extends Model
{
    use HasValidator;
    protected $table = 'shop_size';
    protected $fillable = ['value', 'category_id', 'size_person_id', 'manufacturer_id', 'size_locales_id', 'size_category_id', 'status'];

    const STATUS_DELETE = -1;
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            foreach ($model->attributes as $key => $value) {
                if ($value === '') {
                    unset($model->attributes[$key]);
//                    $model->{$key} = null;
                }
            }

        });
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'category_id' => 'required',
        ];
    }

    public function getStatus($id = null)
    {
        $data = [
            self::STATUS_DELETE => trans('Delete'),
            self::STATUS_INACTIVE => trans('InActive'),
            self::STATUS_ACTIVE => trans('Active'),
        ];
        if (isset($data[$id])) {
            return $data[$id];
        } else {
            return $data;
        }
    }
}
