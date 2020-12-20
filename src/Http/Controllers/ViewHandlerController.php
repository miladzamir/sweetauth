<?php

namespace MiladZamir\SweetAuth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MiladZamir\SweetAuth\Helper;

class ViewHandlerController extends Controller
{
    public function showView()
    {
        $url = array_slice(Helper::getCurrentUrl(), -2);
        $blade = implode('.', $url);
        return view('auth.' . $blade);
    }

}
