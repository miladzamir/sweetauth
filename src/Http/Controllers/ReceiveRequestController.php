<?php

namespace MiladZamir\SweetAuth\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use MiladZamir\Orange\Orange;
use MiladZamir\SweetAuth\Models\SweetOneTimePassword;

class ReceiveRequestController extends Controller
{
    public function ReceiveRequest(Request $request)
    {
        $phoneInputName = config('sweetauth')['oneTimePassword']['phone_input'];

        if (config('sweetauth.validate')) {
            $validator = validator::make($request->all(), [
                $phoneInputName => ['required', 'regex:/(09)[0-9]{9}/', 'digits:11', 'numeric', 'unique:users'],
            ]);

            if ($validator->fails()) {
                return View::make(config('sweetauth')['oneTimePassword']['phone_input_page_src'])
                    ->with($phoneInputName, $request->$phoneInputName)
                    ->withErrors($validator);
            }
        }

        $phoneInformation = SweetOneTimePassword::where('phone', $request->$phoneInputName)->first();


        if ($phoneInformation->is_block == true) {
            if (Carbon::now()->timestamp - $phoneInformation->last_send_at->timestamp > config('sweetauth')['oneTimePassword']['delay_unblock']) {
                $phoneInformation->update([
                    'is_block' => false,
                    'request_times' => 1
                ]);
            } else {
                $remainingAlertMessage = $this->getRemainingTimeMessage($phoneInformation, 'block_user_message');
                $validator->errors()->add('block_user', $remainingAlertMessage);
                return View::make(config('sweetauth')['oneTimePassword']['phone_input_page_src'])
                    ->with($phoneInputName, $request->$phoneInputName)
                    ->withErrors($validator);
            }
        } else {
            if (Carbon::now()->timestamp - $phoneInformation->last_send_at->timestamp < config('sweetauth')['oneTimePassword']['delay_between_request'] && $phoneInformation->request_times > config('sweetauth')['oneTimePassword']['delay_count']) {
                $phoneInformation->update([
                    'is_block' => true,
                    'request_times' => 1
                ]);
            }
        }


        $randomDigitNumber = $this->createRandomDigitNumber();

        $phoneCount = $this->rowExistWithPhoneNumber($phoneInputName, $request);


        if ($phoneInformation != null && Carbon::now()->timestamp - $phoneInformation->last_send_at->timestamp < config('sweetauth')['oneTimePassword']['delay_allowed']) {
            $remainingAlertMessage = $this->getRemainingTimeMessage($phoneInformation, 'delay_allowed_message');
            $validator->errors()->add('delay_request', $remainingAlertMessage);
            return View::make(config('sweetauth')['oneTimePassword']['phone_input_page_src'])
                ->with($phoneInputName, $request->$phoneInputName)
                ->withErrors($validator);
        }

        $sendVerificationSms = Orange::smsLookup($request->$phoneInputName, $randomDigitNumber, '', '', config('sweetauth')['oneTimePassword']['sms_template'])->original['status'];

        if ($sendVerificationSms != 200) {
            $validator->errors()->add('sms_failed_message', config('sweetauth')['oneTimePassword']['sms_failed_message']);
            return View::make(config('sweetauth')['oneTimePassword']['phone_input_page_src'])
                ->with($phoneInputName, $request->$phoneInputName)
                ->withErrors($validator);
        }


        if ($phoneInformation != null) {
            $this->UpdateOneTimePassword($phoneInputName, $request, $randomDigitNumber);
        }else{
            $this->createNewOneTimePassword($phoneInputName, $request, $randomDigitNumber);
        }

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
        $remainingTime = intval($this->getStringBetween(config('sweetauth')['oneTimePassword'][$message], ":", ":"));
        $remainingCoolDown = Carbon::now()->timestamp - $phoneInformation->last_send_at->timestamp;
        return str_replace(':' . $remainingTime . ':', $remainingTime - $remainingCoolDown, config('sweetauth')['oneTimePassword'][$message]);

    }

    /**
     * @param $phoneInputName
     * @param Request $request
     * @param int $randomDigitNumber
     */
    private function createNewOneTimePassword($phoneInputName, Request $request, int $randomDigitNumber): void
    {
        SweetOneTimePassword::create([
            'phone' => $request->$phoneInputName,
            'token' => $randomDigitNumber,
            'last_send_at' => Carbon::now()->timestamp
        ]);
    }

    /**
     * @param $phoneInputName
     * @param Request $request
     * @param int $randomDigitNumber
     */
    private function UpdateOneTimePassword($phoneInputName, Request $request, int $randomDigitNumber): void
    {
        SweetOneTimePassword::where('phone', $request->$phoneInputName)->update([
            'token' => $randomDigitNumber,
            'request_times' => DB::raw('request_times + 1'),
            'last_send_at' => Carbon::now()
        ]);
    }
}
