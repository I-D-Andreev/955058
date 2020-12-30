<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
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
    public function boot()
    {
        //
    }
}
