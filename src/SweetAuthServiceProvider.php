<?php

namespace MiladZamir\SweetAuth;

use Illuminate\Support\ServiceProvider;

class SweetAuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/sweetauth.php' => config_path('sweetauth.php'),
                __DIR__ . '/../database/migrations/create_sweet_one_time_passwords.php.stub' => database_path('migrations/' . '2020_11_01_174513_create_sweet_one_time_passwords_table.php')
            ]);
        }

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }

    public function register()
    {

    }
}
