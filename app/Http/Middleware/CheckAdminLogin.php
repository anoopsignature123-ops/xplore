<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckAdminLogin 
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::get('isAdminLoggedIn', false)) {
            return redirect()->route('admin.auth.login')
                ->with('error', 'Please log in first to access this page.');
        }

        return $next($request);
    }
}