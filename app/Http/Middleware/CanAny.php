<?php
namespace App\Http\Middleware;
use Closure;

class CanAny{
    public function handle($request, Closure $next, ... $roles)
    {
        if (!auth()->user())
        return redirect()->route("home");

        $user = auth()->user();

        if($user->hasPermission('admin'))
            return $next($request);

        foreach($roles as $role) {
            if($user->hasPermission($role))
                return $next($request);
        }

        return redirect()->route("home");
    }
}
