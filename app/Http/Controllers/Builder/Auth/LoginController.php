<?php

namespace App\Http\Controllers\Builder\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        if (Auth::guard('builder')->check()) {
            return redirect()->route('builder.index');
        }
        return view('builder.auth.login');
    }

    public function checkLogin(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');
        $remember    = $request->has('remember');

        if (Auth::guard('builder')->attempt($credentials, $remember)) {
            $builder = Auth::guard('builder')->user();
            if (!$builder->status) {
                Auth::guard('builder')->logout();
                return redirect()->back()->with('error', 'Your account is deactivated. Please contact admin.');
            }
            return redirect()->route('builder.index')->with('success', 'Logged in successfully!');
        }

        return redirect()->back()->with('error', 'Invalid email or password.');
    }

    public function logout()
    {
        Auth::guard('builder')->logout();
        return redirect()->route('builder.auth.login')->with('success', 'Logged out successfully!');
    }
}
