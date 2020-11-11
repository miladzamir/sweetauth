<?php

namespace MiladZamir\SweetAuth\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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


        $randomDigitNumber = $this->createRandomDigitNumber();

        $sendVerificationSms = Orange::smsLookup($request->$stepOneInput, $randomDigitNumber, '', '', config('swauth.orange.template'))->status();

        if ($sendVerificationSms != 200) {
            return back()->withErrors(config('swauth.mainConfig.messages.failedSendSms'));
        }

        if ($phoneInformation == null)
            $this->createNewOneTimePassword($stepOneInput, $request, $randomDigitNumber);
        else
            $this->UpdateOneTimePassword($phoneInformation, $stepOneInput, $request, $randomDigitNumber);

        return 'oj';

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
}
