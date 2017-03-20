<?php
/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 4/19/2016
 * Time: 11:24 AM
 */
namespace App\Http\Middleware;

use App\Services\Payment;
use Closure;
use App\Helpers\AppHelper;

class App
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        \Carbon\Carbon::setLocale(app()->getLocale());
        AppHelper::setReturnUrl($request->url());

        /**
         * Version for css and js when deploy
         */
        $version_deploy = !empty(config('site.main.version_deploy')) ? config('site.main.version_deploy') : 1;
        \View::share('version_deploy', $version_deploy);

        $cart = app(Payment::class)->getCart();
        \View::share('cart', $cart);
        return $next($request);
    }

}