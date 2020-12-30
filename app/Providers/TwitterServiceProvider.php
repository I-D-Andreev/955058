<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Twitter;

class TwitterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Twitter::class, function($app){
            return new Twitter();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Twitter $twitter)
    {
        View::composer('layouts.app', function($view) use($twitter) {
            $view->with('twitter', $twitter);
        });
    }
}
