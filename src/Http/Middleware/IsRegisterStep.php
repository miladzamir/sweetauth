<?php

namespace MiladZamir\SweetAuth\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class IsRegisterStep
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //\session()->flush();
        if (session()->has('isReceiveAndStored')){
            return redirect()->route(config('sweetauth.oneTimePassword.verify_route_name'));
        }elseif (session()->has('isVerify')){
            return redirect()->route(config('sweetauth.oneTimePassword.complete_register_route_name'));
        }else{
            return $next($request);
        }

    }
}
