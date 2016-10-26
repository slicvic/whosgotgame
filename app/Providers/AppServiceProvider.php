<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        $this->app->singleton('App\Services\EventService', function ($app) {
            return new \App\Services\EventService();
        });

        $this->app->singleton('App\Services\RegistrarService', function ($app) {
            return new \App\Services\RegistrarService();
        });
    }
}
