<?php

namespace MiladZamir\SweetAuth;

use Illuminate\Support\ServiceProvider;

class SweetAuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
       dd('Run!');
    }

    public function register()
    {

    }
}
