<?php

namespace App\Http\Middleware;

use Closure;

class Manager
{
    public function handle($request, Closure $next, $guard = null) {
        if (!auth()->user()->manager) {
            abort(404);
        }
        return $next($request);
    }
}
