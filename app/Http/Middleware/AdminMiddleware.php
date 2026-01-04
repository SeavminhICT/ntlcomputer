<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (! $user || ! $user->isAdmin()) {
            return redirect()->route('admin.login')->withErrors([
                'email' => 'Please log in with an admin account.',
            ]);
        }

        return $next($request);
    }
}
