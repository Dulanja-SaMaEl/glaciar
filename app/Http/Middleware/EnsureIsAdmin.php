<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. If not logged in, go to login page
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. If logged in, but ROLE is not admin, stop them.
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'staff') {
            abort(403, 'Unauthorized. Access restricted to Glaciar Staff.');
        }

        return $next($request);
    }
}