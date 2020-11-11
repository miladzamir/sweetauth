<?php

namespace MiladZamir\SweetAuth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MiladZamir\SweetAuth\Helper;

class StepOneController extends Controller
{
    public function configure(Request $request)
    {
        if (Helper::getLastUrl() == config('swauth.viewRouteNames.step1.0'))
            self::validationZero($request);
        elseif (Helper::getLastUrl() == config('swauth.viewRouteNames.step1.1'))
            self::validationOne($request);
        else
            abort(403);


        dd($request->all());
    }

    private function validationZero($request)
    {
        $request->validate([
            config('swauth.inputs.step1') => config('swauth.validations.step1.0'),
        ]);
    }

    private function validationOne($request)
    {
        $request->validate([
            config('swauth.inputs.step1') => config('swauth.validations.step1.1'),
        ]);
    }

}
