<?php

namespace MiladZamir\SweetAuth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ViewPageController extends Controller
{
    public function myView()
    {
        return view('sweetauth::steps.register');
    }

    public function verify()
    {
        return view('sweetauth::steps.verify');
    }

    public function register()
    {
        return view('sweetauth::steps.complete_register');
    }

    public function login()
    {
        return view('sweetauth::steps.login');
    }
}
