<?php

namespace MiladZamir\SweetAuth\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class IsVerify
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
        if (session()->has('isVerify') == true) {
            return $next($request);
        }else{
            return redirect()->route(config('sweetauth.oneTimePassword.verify_route_name'));
        }

    }
}
