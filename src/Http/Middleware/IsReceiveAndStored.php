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
        if (true) {
            return $next($request);
        }

        return View::make(config('sweetauth')['oneTimePassword']['phone_input_page_src']);
    }
}
