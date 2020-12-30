<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\NewsAPI;

class NewsAPIServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(NewsAPI::class, function($app){
            return new NewsAPI();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(NewsAPI $newsApi)
    {
        View::composer('layouts.app', function($view) use($newsApi) {
            $view->with('newsApi', $newsApi);
        });
    }
}
