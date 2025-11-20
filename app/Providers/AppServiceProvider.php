<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $appversion = '1.0.0';
        $lastupdate = '20.11.2025';       
        $appname = 'WBG RCP Panel Łódź';

        // Udostępnienia dla wszystkich widoków
        view()->share('appversion', $appversion);
        view()->share('lastupdate', $lastupdate);       
        view()->share('appname', $appname);

        // Automatyczne ładowanie relacji dla wszystkich modeli
        Model::automaticallyEagerLoadRelationships();
        //\Illuminate\Database\Eloquent\Model::automaticallyEagerLoadRelationships();

        if($this->app->environment('production')) {
            \URL::forceScheme('https');
            request()->server->set('HTTPS', request()->header('X-Forwarded-Proto', 'https') == 'https' ? 'on' : 'off');
        }
    }
}
