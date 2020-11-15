<?php

namespace MiladZamir\SweetAuth\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use MiladZamir\SweetAuth\Helper;
use MiladZamir\SweetAuth\Models\SweetOneTimePassword;

class StepThreeController extends Controller
{
    public function configure(Request $request){

        $stepThreeInputs = config('swauth.inputs.step3');

        $session = Helper::checkSession('step2.0', 'step2.1');
        $phoneInformation = SweetOneTimePassword::where('phone', session($session))->first();

        if (Carbon::now()->timestamp - $phoneInformation->lasStepCompleteAt() < config('swauth.mainConfig.passwordScopeRange') == false) {
            session()->forget($session);
            if ($session == 'step2.0'){
                return redirect()->route(config('swauth.viewRouteNames.step1.0'))
                    ->withErrors(config('swauth.mainConfig.messages.OutOfPasswordScope'));
            }elseif ($session == 'step2.1'){
                return redirect()->route(config('swauth.viewRouteNames.step1.1'))
                    ->withErrors(config('swauth.mainConfig.messages.OutOfPasswordScope'));
            }else{
                abort(403);
            }
        }

        session()->forget($session);


        if ($session == 'step2.0'){
            $user = User::create([
                'phone' => $phoneInformation->phone,
                'password' => $request->input('password')
            ]);
        } elseif ($session == 'step2.1'){
            $user = User::where('phone', $phoneInformation->phone)->update([
                'phone' => $phoneInformation->phone,
                'password' => $request->input('password')
            ]);
        } else
            abort(403);
        $user = User::where('phone', $phoneInformation->phone)->first();
        Auth::loginUsingId($user->id);

        return redirect()->route(config('swauth.mainConfig.redirectLocation'));

        dd($request->all());
    }
}
