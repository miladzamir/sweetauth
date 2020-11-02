<?php

namespace MiladZamir\SweetAuth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HandleRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('is.receive.and.stored');
    }


}
