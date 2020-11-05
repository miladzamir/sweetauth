<?php

namespace MiladZamir\SweetAuth\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class IsReceiveAndStored
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
        if (session()->has('isReceiveAndStored')) {
            return $next($request);
        }

        return redirect()->route(config('sweetauth.oneTimePassword.register_route_name'));
    }
}
