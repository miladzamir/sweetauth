<?php

namespace MiladZamir\SweetAuth;

use MiladZamir\SweetAuth\Http\Middleware\IsReceiveAndStored;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use MiladZamir\SweetAuth\Http\Middleware\IsRegisterStep;
use MiladZamir\SweetAuth\Http\Middleware\IsStepThreeMethodOne;
use MiladZamir\SweetAuth\Http\Middleware\IsStepThreeMethodPost;
use MiladZamir\SweetAuth\Http\Middleware\IsStepThreeMethodZero;
use MiladZamir\SweetAuth\Http\Middleware\IsStepTwo;
use MiladZamir\SweetAuth\Http\Middleware\IsStepTwoMethodOne;
use MiladZamir\SweetAuth\Http\Middleware\IsStepTwoMethodPost;
use MiladZamir\SweetAuth\Http\Middleware\IsStepTwoMethodZero;
use MiladZamir\SweetAuth\Http\Middleware\IsVerify;

class SweetAuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/swauth.php' => config_path('swauth.php'),
                __DIR__ . '/../database/migrations/create_sweet_one_time_passwords.php.stub' => database_path('migrations/' . '2020_11_01_174513_create_sweet_one_time_passwords_table.php'),
            ]);
        }
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'swAuth');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }

    public function register()
    {

    }
}
