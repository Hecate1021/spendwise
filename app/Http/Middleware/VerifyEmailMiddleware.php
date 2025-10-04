<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;

class VerifyEmailMiddleware
{
    public function handle($request, Closure $next)
    {
        // Get user from session instead of Auth
        $username = session('username');
        $user = $username ? User::where('username', $username)->first() : null;



        if (is_null($user->email_verified_at)) {
            // logged in but not verified → send to verify page
            return redirect()->route('register.verify')
                             ->with('error', 'Please verify your email first.');
        }

        return $next($request);
    }
}
