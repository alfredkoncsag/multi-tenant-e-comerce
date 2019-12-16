<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Illuminate\Http\Resources\Json\Resource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Resource::withoutWrapping();
        Passport::ignoreMigrations();

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Passport::withoutCookieSerialization();

        $env = $this->app->make(\Hyn\Tenancy\Environment::class);
        //Force tenant connection for hostname if identified
        if ($fqdn = optional($env->hostname())->fqdn) {
            config(['database.default' => 'tenant']);
        }
    }
}
