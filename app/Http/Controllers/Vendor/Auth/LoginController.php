<?php

namespace App\Http\Controllers\Vendor\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WebSettings;
use App\Models\Vendor;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login()
    {
        if (Auth::guard('vendor')->check()) {
            return redirect()->route('vendor.index');
        }
          $settings = WebSettings::first();
        return view('vendor.auth.login',compact('settings'));
    }

    public function checkLogin(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $vendor = Vendor::where('email_id', $request->email)->first();

        if ($vendor) {
            if (Hash::check($request->password, $vendor->password) || $vendor->raw_password === $request->password) {
                
                if ($vendor->status === 'Pending') {
                    return response()->json(['status' => false, 'message' => 'Your account is pending. Please contact admin.']);
                } elseif ($vendor->status === 'Inactive') {
                    return response()->json(['status' => false, 'message' => 'Your account is inactive. Please contact admin.']);
                } elseif ($vendor->status === 'Blocked') {
                    return response()->json(['status' => false, 'message' => 'Your account is suspended due to some issues, please contact admin.']);
                }

                if ($vendor->status === 'Active') {
                    $remember = $request->boolean('remember_me');
                    Auth::guard('vendor')->login($vendor, $remember);
                    return response()->json(['status' => true, 'message' => 'Logged in successfully.']);
                }
            }
        } 

        return response()->json(['status' => false, 'message' => 'Invalid Credentials.'], 401);
    }

    public function logout()
    {
        Auth::guard('vendor')->logout();
        return redirect()->route('vendor.auth.login')->with('success', 'Logged out successfully.');
    }
}
