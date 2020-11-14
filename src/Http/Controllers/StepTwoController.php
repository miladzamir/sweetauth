<?php

namespace MiladZamir\SweetAuth\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use MiladZamir\SweetAuth\Helper;
use MiladZamir\SweetAuth\Models\SweetOneTimePassword;

class StepTwoController extends Controller
{
    public function configure(Request $request)
    {
        $stepTwoInput = config('swauth.inputs.step2');

        self::validationToken($request, $stepTwoInput);
        $session = Helper::checkSession('step1.0', 'step1.1');

        $phoneInformation = SweetOneTimePassword::where('phone', session($session))->first();

        if (Carbon::now()->timestamp - $phoneInformation->lastSmsSendAt() > config('swauth.mainConfig.scopeRange')) {
            session()->forget($session);
            if ($session == 'step1.0'){
                return redirect()->route(config('swauth.viewRouteNames.step1.0'))
                    ->withErrors(config('swauth.mainConfig.messages.outOfScope'));
            }elseif ($session == 'step1.1'){
                return redirect()->route(config('swauth.viewRouteNames.step1.1'))
                    ->withErrors(config('swauth.mainConfig.messages.outOfScope'));
            }else{
                abort(403);
            }
        }

        if ($phoneInformation->token != $request->$stepTwoInput){
            return back()->withErrors(config('swauth.mainConfig.messages.invalidVerify'));
        }

        session()->forget($session);

        $phoneInformation->update([
            'last_step_complete_at' => Carbon::now(),
        ]);

        if ($session == 'step1.0'){
            Session::put('step2.0' , $request->$stepTwoInput);
            return redirect()->route(config('swauth.viewRouteNames.step3.0'));
        } elseif ($session == 'step1.1'){
            Session::put('step2.1' , $request->$stepTwoInput);
            return redirect()->route(config('swauth.viewRouteNames.step3.1'));
        } else
            abort(403);


    }

    private function validationToken($request, $input)
    {
        $request->validate([
            $input => config('swauth.validations.step2'),
        ]);
    }
}
