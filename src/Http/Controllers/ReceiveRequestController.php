<?php

namespace MiladZamir\SweetAuth\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use MiladZamir\Orange\Orange;
use MiladZamir\SweetAuth\Models\SweetOneTimePassword;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;

class ReceiveRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('is.register.step');
    }

    public function ReceiveRequest(Request $request)
    {
        $phoneInputName = config('sweetauth.oneTimePassword.phone_input');

        $validator = validator::make($request->all(), [
            $phoneInputName => config('sweetauth.validateRules'),
        ]);

        if ($validator->fails()) {
            return view('sweetauth::' . 'steps.' . config('sweetauth.oneTimePassword.phone_input_page_src'))
                ->withErrors($validator);
        }

        $phoneInformation = SweetOneTimePassword::where('phone', $request->$phoneInputName)->first();

        if ($phoneInformation != null) {
            if ($phoneInformation->is_block == true) {
                $blockResult = $this->blockSystem($phoneInformation);

                if ($blockResult != false) {
                    return view('sweetauth::' . 'steps.' . config('sweetauth.oneTimePassword.phone_input_page_src'))
                        ->withErrors($blockResult);
                }

            } else {
                if (Carbon::now()->timestamp - $phoneInformation->getLastSendAt() < config('sweetauth.oneTimePassword.delay_between_request') && $phoneInformation->request_times > config('sweetauth.oneTimePassword.delay_count')) {
                    $phoneInformation->update([
                        'is_block' => true,
                        'request_times' => 1
                    ]);
                    $blockResult = $this->blockSystem($phoneInformation);

                    if ($blockResult != false) {
                        return view('sweetauth::' . 'steps.' . config('sweetauth.oneTimePassword.phone_input_page_src'))
                            ->withErrors($blockResult);
                    }
                }
            }
        }

        $randomDigitNumber = $this->createRandomDigitNumber();

        $phoneCount = $this->rowExistWithPhoneNumber($phoneInputName, $request);


        if ($phoneInformation != null && Carbon::now()->timestamp - $phoneInformation->getLastSendAt() < config('sweetauth')['oneTimePassword']['delay_allowed']) {
            $remainingAlertMessage = $this->getRemainingTimeMessage($phoneInformation, 'delay_allowed_message');
            return view('sweetauth::' . 'steps.' . config('sweetauth.oneTimePassword.phone_input_page_src'))
                ->withErrors($remainingAlertMessage);
        }

        //$sendVerificationSms = Orange::smsLookup($request->$phoneInputName, $randomDigitNumber, '', '', config('sweetauth')['oneTimePassword']['sms_template'])->original['status'];
        $sendVerificationSms = 200;

        if ($sendVerificationSms != 200) {
            return view('sweetauth::' . 'steps.' . config('sweetauth.oneTimePassword.phone_input_page_src'))
                ->withErrors(config('sweetauth.oneTimePassword.sms_failed_message'));
        }


        $rToken = $this->createToken();

        if ($phoneInformation != null) {
            $this->UpdateOneTimePassword($phoneInputName, $request, $randomDigitNumber, $rToken);
        } else {
            $this->createNewOneTimePassword($phoneInputName, $request, $randomDigitNumber, $rToken);
        }

        Session::put('isReceiveAndStored' , $request->$phoneInputName);
        return redirect()->route('verify');
    }

    /**
     * @return int
     */
    private function createRandomDigitNumber()
    {
        return intval(substr(str_shuffle("0123456789"), 0, config('sweetauth')['oneTimePassword']['code_length']));
    }

    /**
     * @param $phoneInputName
     * @param Request $request
     */
    private function rowExistWithPhoneNumber($phoneInputName, Request $request)
    {
        return SweetOneTimePassword::where('phone', $request->$phoneInputName);
    }

    private function getStringBetween($str, $from, $to)
    {
        $sub = substr($str, strpos($str, $from) + strlen($from), strlen($str));
        return substr($sub, 0, strpos($sub, $to));
    }

    /**
     * @param $phoneInformation
     * @return string|string[]
     */
    private function getRemainingTimeMessage($phoneInformation, $message)
    {
        $remainingTime = intval($this->getStringBetween(config('sweetauth.oneTimePassword')[$message], ":", ":"));
        $remainingCoolDown = Carbon::now()->timestamp - $phoneInformation->getLastSendAt();
        return str_replace(':' . $remainingTime . ':', $remainingTime - $remainingCoolDown, config('sweetauth')['oneTimePassword'][$message]);

    }

    /**
     * @param $phoneInputName
     * @param Request $request
     * @param int $randomDigitNumber
     */
    private function createNewOneTimePassword($phoneInputName, Request $request, int $randomDigitNumber, $rToken): void
    {
        SweetOneTimePassword::create([
            'phone' => $request->$phoneInputName,
            'token' => $randomDigitNumber,
            'last_step_complete_at' => Carbon::now(),
            'last_send_at' => Carbon::now(),
            'r_token' => $rToken
        ]);
    }

    /**
     * @param $phoneInputName
     * @param Request $request
     * @param int $randomDigitNumber
     */
    private function UpdateOneTimePassword($phoneInputName, Request $request, int $randomDigitNumber, $rToken): void
    {
        SweetOneTimePassword::where('phone', $request->$phoneInputName)->update([
            'token' => $randomDigitNumber,
            'request_times' => DB::raw('request_times + 1'),
            'last_step_complete_at' => Carbon::now(),
            'last_send_at' => Carbon::now(),
            'r_token' => $rToken
        ]);
    }


    /**
     * @return string
     * @throws \Exception
     */
    private function createToken(): string
    {
        return bin2hex(random_bytes(24));
    }

    private function blockSystem($phoneInformation)
    {
        if (Carbon::now()->timestamp - $phoneInformation->getLastSendAt() > config('sweetauth.oneTimePassword.delay_unblock')) {
            $phoneInformation->update([
                'is_block' => false,
                'request_times' => 1
            ]);
            return false;
        } else {
            $remainingAlertMessage = $this->getRemainingTimeMessage($phoneInformation, 'block_user_message');
            return $remainingAlertMessage;
        }
    }

}
