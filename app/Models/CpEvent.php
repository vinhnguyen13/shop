<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CpEvent extends Model
{
    const TYPE_PUBLIC = 1;
    const TYPE_SYSTEM = 2;

    protected $table = 'cp_event';

    public $timestamps = false;

    protected $guarded = ['id'];
    protected $fillable = ['name', 'description', 'status', 'type', 'created_at', 'created_by', 'start_date', 'end_date'];

    public static $rules = [
        'name' => 'required|unique:cp_event|max:255',
        'status' => 'integer',
        'type' => 'integer',
        'created_at' => 'integer',
        'created_by' => 'integer',
        'start_date' => 'required',
        'end_date' => 'required|after:start_date',
    ];

    public static function getTypes($id = null)
    {
        $data = [
            self::TYPE_PUBLIC => 'Public',
            self::TYPE_SYSTEM => 'System',
        ];

        if ($id !== null && isset($data[$id])) {
            return $data[$id];
        } else {
            return $data;
        }
    }
}
