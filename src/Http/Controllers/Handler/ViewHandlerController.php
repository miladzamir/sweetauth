<?php

namespace MiladZamir\SweetAuth\Http\Controllers\Handler;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ViewHandlerController extends Controller
{
    public function stepOneMethodZero()
    {
        return view('swAuth::step1')->with('state', 'stepOneMethodZero');
    }

    public function stepOneMethodOne()
    {
        return view('swAuth::step1')->with('state', 'stepOneMethodOne');
    }

    public function stepTwoMethodZero()
    {
        return view('swAuth::step2')->with('state', 'stepTwoMethodZero');
    }

    public function stepTwoMethodOne()
    {
        return view('swAuth::step2')->with('state', 'stepTwoMethodOne');
    }

    public function stepThreeMethodZero()
    {
        return view('swAuth::step3')->with('state', 'stepThreeMethodZero');
    }

    public function stepThreeMethodOne()
    {
        return view('swAuth::step3')->with('state', 'stepThreeMethodOne');
    }
    public function stepFourMethodZero()
    {
        return view('swAuth::step4')->with('state', 'stepFourMethodZero');
    }


}
