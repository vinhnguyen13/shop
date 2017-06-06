<?php
/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 4/19/2016
 * Time: 11:27 AM
 */
namespace App\Http\Controllers\Rest;

use App\Http\Controllers\Controller;
use App\Models\Rest\User;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
{
    public function index()
    {
        $user = \DB::table('users')->limit(1000)->get();
        return $user;
    }


}