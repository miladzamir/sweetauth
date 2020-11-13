<?php

namespace MiladZamir\SweetAuth\Http\Middleware;

use Closure;

class IsStepThreeMethodZero
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (session()->has('step2.0')) {
            return $next($request);
        }

        return back();
    }
}
