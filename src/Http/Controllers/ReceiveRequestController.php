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

        $checkBlock = SweetOneTimePassword::where('phone', $request->$phoneInputName)->first();

        if ($checkBlock->is_block == true && Carbon::now()->timestamp - $checkBlock->last_send_at->timestamp > config('sweetauth')['oneTimePassword']['delay_unblock']) {
            $checkBlock->update([
                'is_block' => false,
                'request_times' => 1
            ]);
        } else {
            if (Carbon::now()->timestamp - $checkBlock->last_send_at->timestamp < config('sweetauth')['oneTimePassword']['delay_between_request'] && $checkBlock->request_times > config('sweetauth')['oneTimePassword']['delay_count']) {
                $checkBlock->update([
                    'is_block' => true,
                    'request_times' => 1
                ]);
            }
        }


        $randomDigitNumber = $this->createRandomDigitNumber();

        $phoneCount = $this->rowExistWithPhoneNumber($phoneInputName, $request);
        if ($phoneCount->count() != 0) {
            if (SweetOneTimePassword::where('phone', $request->$phoneInputName)->first()->is_block == true) {
                $validator->errors()->add('block_user', config('sweetauth')['oneTimePassword']['block_user_message']);
                return View::make(config('sweetauth')['oneTimePassword']['phone_input_page_src'])
                    ->with($phoneInputName, $request->$phoneInputName)
                    ->withErrors($validator);
            }
        }

        $sendVerificationSms = Orange::smsLookup($request->$phoneInputName, $randomDigitNumber, '', '', config('sweetauth')['oneTimePassword']['sms_template'])->original['status'];

        if ($sendVerificationSms != 200) {
            $validator->errors()->add('sms_failed_message', config('sweetauth')['oneTimePassword']['sms_failed_message']);
            return View::make(config('sweetauth')['oneTimePassword']['phone_input_page_src'])
                ->with($phoneInputName, $request->$phoneInputName)
                ->withErrors($validator);
        }


        if ($phoneCount->count() == 0) {
            SweetOneTimePassword::create([
                'phone' => $request->$phoneInputName,
                'token' => $randomDigitNumber,
                'last_send_at' => Carbon::now()->timestamp
            ]);
        } else {
            SweetOneTimePassword::where('phone', $request->$phoneInputName)->update([
                'token' => $randomDigitNumber,
                'request_times' => DB::raw('request_times + 1'),
                'last_send_at' => Carbon::now()
            ]);
        }
    }


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

}
