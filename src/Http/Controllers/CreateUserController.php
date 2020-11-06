<?php

namespace MiladZamir\SweetAuth\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CreateUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('is.verify');
    }

    public function CreateUser(Request $request)
    {

        $PasswordInputName = config('sweetauth.oneTimePassword.password_input');
        $request->validate([
            $PasswordInputName => config('sweetauth.completeRegisterRules'),
        ]);

        $user = User::create([
            'phone' => session('isVerify'),
            'password' => bcrypt($request->password)
        ]);

        Session::forget('isVerify');

        Auth::loginUsingId($user->id);

        return redirect('/home');
    }

}
