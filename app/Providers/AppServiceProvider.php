<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\FileViewFinder;
use Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        require_once __DIR__ . '/../Helpers/helpers.php';
        /**
         * set themes
         */
        $this->app->bind('view.finder', function($app)
        {
            $paths = $app['config']['view.paths'];
            if(Request::is('admin') || Request::is('admin/*')){
                $theme = \Config::get('site.theme.backend');
            }elseif(Request::is('api') || Request::is('api/*')){
                $theme = \Config::get('site.theme.backend');
            }else{
                $theme = \Config::get('site.theme.frontend');
            }
//            $paths = Config::get('view.paths');
            array_unshift($paths, base_path() . '/resources/themes/' . $theme . '/views');
            \Config::set('view.paths', $paths);

            return new FileViewFinder($app['files'], $paths);
        });
    }
}
