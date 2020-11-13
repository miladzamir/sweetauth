<?php

namespace MiladZamir\SweetAuth\Http\Middleware;

use Closure;
use MiladZamir\SweetAuth\Helper;

class IsStepThreeMethodPost
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
        if (session()->has('step2.0') || session()->has('step2.1')) {
            return $next($request);
        }
        return back();
    }
}
