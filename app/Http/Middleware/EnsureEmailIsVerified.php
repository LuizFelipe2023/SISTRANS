<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            if (is_null($user->email_verified_at)) {
                return redirect()->route('auth.verifyEmailForm')->with('error', 'Por favor, verifique seu e-mail.');
            }
        } else {
            return redirect()->route('auth.login')->with('error', 'Você precisa estar logado.');
        }

        return $next($request);
    }
}
