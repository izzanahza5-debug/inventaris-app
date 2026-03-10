<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;

use Closure;
use Illuminate\Support\Facades\Auth;
class RedirectIfLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            // Jangan gunakan back(), arahkan langsung ke dashboard
            return redirect('/dashboard'); 
        }

        return $next($request);
    }
}
