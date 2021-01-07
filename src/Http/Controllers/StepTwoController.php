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
        $url = array_slice(Helper::getLastUrl(true), -2);
        $config = implode('.', $url);

        $tbl = null;
        foreach (config('swauth.table') as $table){
            foreach ($table['viewRouteNames'] as $key=>$view){
                if ($config == $key)
                    $tbl = $table;
            }
        }
        $stepTwoInput = config('swauth.table.'. $tbl['table'] .'.inputs.step2');

        $viewRouteName = config('swauth.table.'. $tbl['table'] . '.viewRouteNames');
        $this_ = $viewRouteName[$config] ?? null;

        if (isset($this_['validations']))
            self::validationRequest($request, $stepTwoInput, $this_['validations']);
        else
            abort(403);

        $oldSession = session($this_['session']['old']);
        $phoneInformation = SweetOneTimePassword::where('phone', $oldSession)->first();

        if (Carbon::now()->timestamp - $phoneInformation->lasStepCompleteAt() < config('swauth.mainConfig.scopeRange') == false) {
            session()->forget($oldSession);
            return redirect()->route($this_['prevRoute'])
                ->withErrors(config('swauth.mainConfig.messages.outOfScope'));
        }

        if ($phoneInformation->token != $request->$stepTwoInput){
            return redirect()->back()->withErrors(config('swauth.mainConfig.messages.invalidVerify'));
        }

        session()->forget($oldSession);

        $phoneInformation->update([
            'last_step_complete_at' => Carbon::now(),
        ]);


        if (isset($this_)){
            Session::put($this_['session']['new'], $oldSession);
            return redirect()->route($this_['nextRoute']);
        } else
            abort(403);

    }

    private function validationRequest($request, $input, $validations)
    {
        $request->validate([
            $input => $validations,
        ]);
    }
}
