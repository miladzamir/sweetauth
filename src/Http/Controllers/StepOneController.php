<?php

namespace MiladZamir\SweetAuth\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use MiladZamir\Orange\Orange;
use MiladZamir\SweetAuth\Helper;
use MiladZamir\SweetAuth\Models\SweetOneTimePassword;

class StepOneController extends Controller
{
    public function configure(Request $request)
    {
        $stepOneInput = config('swauth.inputs.step1');

        if (Helper::getLastUrl() == config('swauth.viewRouteNames.step1.0'))
            self::validationZero($request, $stepOneInput);
        elseif (Helper::getLastUrl() == config('swauth.viewRouteNames.step1.1'))
            self::validationOne($request, $stepOneInput);
        else
            abort(403);

        $phoneInformation = SweetOneTimePassword::where(config('swauth.inputs.step1') ,$request->$stepOneInput)->first();


        if ($phoneInformation != null){
            if ($this->blockSystem($phoneInformation) != 'userAllowed'){
                $error = $this->getRemainingTimeMessage($phoneInformation, 'unBanAt');
                return back()->withErrors($error);
            }
            if (Carbon::now()->timestamp - $phoneInformation->lastSmsSendAt() < $this->getStringBetween(config('swauth.mainConfig.messages.nextRequestAt'), ":", ":")) {
                $error = $this->getRemainingTimeMessage($phoneInformation, 'nextRequestAt');
                return back()->withErrors($error);
            }
        }

        $randomDigitNumber = $this->createRandomDigitNumber();

        $sendVerificationSms = Orange::smsLookup($request->$stepOneInput, $randomDigitNumber, '', '', config('swauth.orange.template'))->status();

        if ($sendVerificationSms != 200) {
            return back()->withErrors(config('swauth.mainConfig.messages.failedSendSms'));
        }

        if ($phoneInformation == null)
            $this->createNewOneTimePassword($stepOneInput, $request, $randomDigitNumber);
        else
            $this->UpdateOneTimePassword($phoneInformation, $stepOneInput, $request, $randomDigitNumber);


        if (Helper::getLastUrl() == config('swauth.viewRouteNames.step1.0')){
            Session::put('step1.0' , $request->$stepOneInput);
            return redirect()->route(config('swauth.viewRouteNames.step2.0'));
        }
        elseif (Helper::getLastUrl() == config('swauth.viewRouteNames.step1.1')){
            Session::put('step1.1' , $request->$stepOneInput);
            return redirect()->route(config('swauth.viewRouteNames.step2.1'));
        }
        else
            abort(403);

    }

    private function validationZero($request, $input)
    {
        $request->validate([
            $input => config('swauth.validations.step1.0'),
        ]);
    }

    private function validationOne($request, $input)
    {
        $request->validate([
            $input => config('swauth.validations.step1.1'),
        ]);
    }

    private function createRandomDigitNumber()
    {
        $result = intval(substr(str_shuffle("0123456789"), 0, config('swauth.mainConfig.codeLength')));

        while (strlen($result) != config('swauth.mainConfig.codeLength')){
            $result = intval(substr(str_shuffle("0123456789"), 0, config('swauth.mainConfig.codeLength')));
        }
        return $result;
    }


    private function createNewOneTimePassword($stepOneInput, Request $request, int $randomDigitNumber)
    {
        SweetOneTimePassword::create([
            'phone' => $request->$stepOneInput,
            'token' => $randomDigitNumber,
            'last_step_complete_at' => Carbon::now(),
            'last_sms_send_at' => Carbon::now()
        ]);
    }

    private function UpdateOneTimePassword($phoneInformation, $stepOneInput, Request $request, int $randomDigitNumber): void
    {
        $phoneInformation->update([
            'phone' => $request->$stepOneInput,
            'token' => $randomDigitNumber,
            'request_times' => DB::raw('request_times + 1'),
            'last_step_complete_at' => Carbon::now(),
            'last_sms_send_at' => Carbon::now()
        ]);
    }

    private function getStringBetween($str, $from, $to)
    {
        $sub = substr($str, strpos($str, $from) + strlen($from), strlen($str));
        return substr($sub, 0, strpos($sub, $to));
    }

    private function getRemainingTimeMessage($phoneInformation, $state)
    {
        $remainingTime = intval($this->getStringBetween(config('swauth.mainConfig.messages')[$state], ":", ":"));
        $remainingCoolDown = Carbon::now()->timestamp - $phoneInformation->lastSmsSendAt();
        return str_replace(':' . $remainingTime . ':', $remainingTime - $remainingCoolDown, config('swauth.mainConfig.messages')[$state]);
    }

    private function blockSystem($phoneInformation)
    {
        if ($phoneInformation->is_block == false){
            if (Carbon::now()->timestamp - $phoneInformation->lastSmsSendAt() < config('swauth.mainConfig.delayBetweenRequest') && $phoneInformation->request_times > config('swauth.mainConfig.delayAllowedRequest')) {
                $phoneInformation->update([
                    'is_block' => true,
                    'request_times' => 1
                ]);
                return 'userLimited';
            }else{
                return 'userAllowed';
            }
        }else{
            if (Carbon::now()->timestamp - $phoneInformation->lastSmsSendAt() > $this->getStringBetween(config('swauth.mainConfig.messages.unBanAt'), ":", ":")) {
                $phoneInformation->update([
                    'is_block' => false,
                    'request_times' => 1
                ]);
                return 'userAllowed';
            }else{
                return 'userLimited';
            }
        }
    }
}
