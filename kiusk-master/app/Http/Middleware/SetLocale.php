<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class SetLocale
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
        if(Auth::check()){
            App::setLocale( Auth::user()->lang ?: config('app.locale') );
        }else{
            if(session('currentLanguage')){
                App::setLocale( session('currentLanguage') ?: config('app.locale') );
            }else{
                App::setLocale( Cookie::get('lang') ?: config('app.locale') );
            }
        }
        return $next($request);
    }
}
