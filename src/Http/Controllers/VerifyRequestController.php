<?php

namespace MiladZamir\SweetAuth\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use MiladZamir\SweetAuth\Models\SweetOneTimePassword;

class VerifyRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('is.receive.and.stored');
    }

    public function VerifyRequest(Request $request)
    {
        $tokenInputName = config('sweetauth.oneTimePassword.token_input');

        $request->validate([
            $tokenInputName => config('sweetauth.tokenValidateRules'),
        ]);

        $phoneNumber = session('isReceiveAndStored');

        $phoneInformation = SweetOneTimePassword::where('phone', $phoneNumber)->first();

        if (Carbon::now()->timestamp - $phoneInformation->getLastSendAt() > config('sweetauth.oneTimePassword.accept_token_scope')){
            Session::flush('isReceiveAndStored');
            return redirect()->route(config('sweetauth.oneTimePassword.register_route_name'))
                ->withErrors(config('sweetauth.oneTimePassword.accept_token_scope_message'));
        }

        if ($phoneInformation->token != $request->$tokenInputName){
            return redirect()->route(config('sweetauth.oneTimePassword.verify_route_name'))
                ->withErrors(config('sweetauth.oneTimePassword.wrong_token_message'));
        }

        Session::put('isVerify' , $phoneNumber);
        Session::forget('isReceiveAndStored');

        return redirect()->route('register');


    }

}
