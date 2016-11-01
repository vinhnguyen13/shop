<?php
namespace App\Services;
use App\Models\AuthAssignment;
use App\Models\AuthItem;
use Illuminate\Support\Facades\Gate;

/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 9/7/2016
 * Time: 1:53 PM
 */
class AuthManager
{
    protected $items;

    /**
     * Register policies
     */
    public static function registerPolicies(){
        Gate::define('isAdmin', function ($user) {
            return $user->roles;
        });
    }
}