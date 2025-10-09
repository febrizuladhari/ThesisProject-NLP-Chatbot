<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if (!auth()->check() || !auth()->user()->isAdmin()) {
        //     abort(403, 'Unauthorized action.');
        // }

        if (!Auth::check()) {
            abort(403, 'Unauthorized action. (Not logged in)');
        }

        $user = Auth::user();

        if (!$user || !$user->isAdmin()) {
            abort(403, 'Unauthorized action. (Not an admin)');
        }

        return $next($request);
    }
}
