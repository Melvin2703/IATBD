<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlockBlockedUsers
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->is_blocked) {
            // If the user is blocked, redirect them or show an error page
            return redirect()->route('blocked_page');
        }

        return $next($request);
    }
}
