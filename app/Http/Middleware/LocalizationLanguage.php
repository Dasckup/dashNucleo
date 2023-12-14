<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class LocalizationLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $languages = explode(',', $request->server('HTTP_ACCEPT_LANGUAGE'));

        $languageUser = isset($_COOKIE['language_user'])? $_COOKIE['language_user'] : null;

        if(!empty($languageUser)){
            App::setLocale($languageUser);
        } else {
            if($languages !== null){
                App::setLocale($languages[0]);
            } else {
                App::setLocale('en');
            }
        }

        return $next($request);
    }
}
