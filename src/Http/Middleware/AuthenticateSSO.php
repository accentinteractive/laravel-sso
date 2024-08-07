<?php

namespace Accentinteractive\LaravelSso\Http\Middleware;

use Accentinteractive\LaravelSso\Services\Sso\AzureADSso;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateSSO
{

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()) {
            // We are already logged in
            return $next($request);
        }

        if (config('sso.enabled') == false) {
            // SSO is not enabled
            return $next($request);
        }

        $sso = new AzureADSso();

        if ($sso->requestIsAzureRedirect() === false) {
            return redirect($sso->getAzureLoginUrl());
        }

        if ($sso->isValidAzureLoginRequest() === false) {
            $sso->abort(__('You are not logged in correctly'));
        }

        if ($sso->loginUsingStateToken()) {
            $request->session()->flash('success', __('You are logged in.'));
        }

        return $next($request);
    }
}
