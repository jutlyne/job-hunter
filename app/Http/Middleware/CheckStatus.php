<?php

namespace App\Http\Middleware;

use App\Enums\UserStatus;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        //If the status is not approved redirect to login 
        if (Auth::check() && Auth::user()->status == UserStatus::BLOCK) {
            Auth::logout();
            return redirect('/login')->with('error', 'Your account is block');
        } elseif (Auth::check() && Auth::user()->status == UserStatus::PENDING) {
            return redirect('/verify')->with('error', 'You need to confirm before logging in');
        }

        return $response;
    }
}
