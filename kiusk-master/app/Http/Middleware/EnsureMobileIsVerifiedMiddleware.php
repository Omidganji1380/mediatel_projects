<?php

namespace App\Http\Middleware;

use App\Interfaces\MustVerifyMobile;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class EnsureMobileIsVerifiedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $redirectToRoute = null)
    {
        if(! $request->user() ||
            ($request->user() instanceof MustVerifyMobile &&
            ! $request->user()->hasVerifiedMobile())) {
                return $request->expectsJson()
                    ? abort(403, __('messages.mobile_verification_error'))
                    : Redirect::guest(URL::route($redirectToRoute ?: 'front.panel.user.profile.edit') . "#verify-phone");
        }

        return $next($request);
    }
}
