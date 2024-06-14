<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CekRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param mixed $role  [1. admin | 2. kasir]
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$role)
    {
        if (auth()->user() && in_array(auth()->user()->role, $role)) {
            return $next($request);
        }

        return redirect()->route('dashboard');
    }
}
