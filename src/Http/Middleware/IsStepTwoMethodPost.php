<?php

namespace MiladZamir\SweetAuth\Http\Middleware;

use Closure;
use MiladZamir\SweetAuth\Helper;

class IsStepTwoMethodPost
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
        if (session()->has('step1.0') || session()->has('step1.1')) {
            return $next($request);
        }
        return back();
    }
}
