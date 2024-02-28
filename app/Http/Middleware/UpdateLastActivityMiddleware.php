<?php

namespace App\Http\Middleware;

use Closure;

class UpdateLastActivityMiddleware
{
    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            auth()->user()->updateActivity();
        }

        return $next($request);
    }
}
