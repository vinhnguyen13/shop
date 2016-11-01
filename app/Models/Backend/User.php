<?php

namespace App\Models\Backend;
use App\Helpers\Grid;
use App\Models\User as MainUser;
use DB;

/**
 * App\Modules\Backend\Models\User
 *
 * @mixin \Eloquent
 */
class User extends MainUser
{
    public function gridUser(){
        $query = DB::table('users AS a');
        $grid = new Grid($query, [
            'id',
            'name' => [
                'label' => 'Name',
                'filter' => 'like',
            ],
            'email' => [
                'filter' => 'like',
            ],
            'created_at'=> [
                'label'=>'Registration Time',
            ],
        ]);
        return $grid;
    }
}