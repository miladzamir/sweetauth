<?php

namespace MiladZamir\SweetAuth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MiladZamir\SweetAuth\Helper;
use MiladZamir\SweetAuth\Models\SweetOneTimePassword;

class StepTwoController extends Controller
{
    public function configure(Request $request)
    {
        $stepTwoInput = config('swauth.inputs.step2');

        self::validationToken($request, $stepTwoInput);
        $session = Helper::checkSession('step1.0','step1.1');

        $phoneInformation = SweetOneTimePassword::where('phone', session($session))->first();
        dd($phoneInformation);
    }

    private function validationToken($request, $input)
    {
        $request->validate([
            $input => config('swauth.validations.step2'),
        ]);
    }
}
