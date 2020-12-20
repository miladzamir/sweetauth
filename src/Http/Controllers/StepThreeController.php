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
    public function configure(Request $request)
    {

        $url = array_slice(Helper::getLastUrl(true), -2);
        $config = implode('.', $url);

        $tbl = null;
        foreach (config('swauth.table') as $table) {
            foreach ($table['viewRouteNames'] as $key => $view) {
                if ($config == $key)
                    $tbl = $table;
            }
        }
        $stepThreeInputs = config('swauth.table.' . $tbl['table'] . '.inputs.step3');

        $viewRouteName = config('swauth.table.' . $tbl['table'] . '.viewRouteNames');
        $this_ = $viewRouteName[$config] ?? null;

        if (isset($this_['validations']))
            self::validationRequest($request, $stepThreeInputs, $this_['validations']);
        else
            abort(403);

        $oldSession = session($this_['session']['old']);

        $phoneInformation = SweetOneTimePassword::where('phone', $oldSession)->first();

        if (Carbon::now()->timestamp - $phoneInformation->lasStepCompleteAt() < config('swauth.mainConfig.passwordScopeRange') == false) {
            session()->forget($oldSession);
            return redirect()->route($this_['prevRoute'])
                ->withErrors(config('swauth.mainConfig.messages.outOfScope'));
        }

        session()->forget($oldSession);

        $model = rtrim($tbl['table'], "s");
        $model = ucfirst($model);
        $stepOneInput = config('swauth.table.'. $tbl['table'] .'.inputs.step1');

        $data = [];
        $NamespacedModel = '\\App\\' . $model;

        if ($request->input($stepThreeInputs[1]) != null){
            $data[$stepOneInput] = $phoneInformation->$stepOneInput;
            $data[$stepThreeInputs[0]] = bcrypt($request->input('password'));
            $data[$stepThreeInputs[1]] = $request->input($stepThreeInputs[1]);
            $NamespacedModel::create($data);
        }else{
            $NamespacedModel::where($stepOneInput, $phoneInformation->$stepOneInput)->update(
                array($stepThreeInputs[0] => bcrypt($request->input('password')))
            );
        }

        $user = $NamespacedModel::where($stepOneInput, $phoneInformation->$stepOneInput)->first();
        \auth()->guard(config('swauth.table.'. $tbl['table'] .'.guard'))->loginUsingId($user);

        return redirect()->route(config('swauth.table.'. $tbl['table'] .'.redirectLocation'));
    }

    private function validationRequest($request, $input, $validations)
    {
        if (is_array($input)) {
            foreach ($input as $key => $inp) {
                $request->validate([
                    $inp => $validations[$key],
                ]);
            }
        } else {
            $request->validate([
                $input => $validations,
            ]);
        }
    }
}
