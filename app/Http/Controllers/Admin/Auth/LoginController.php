<?php
namespace App\Http\Controllers\Admin\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use App\Models\WebSettings;
use Illuminate\Support\Facades\ {
    Auth, Hash, Session, Validator
};
use App\Models\User;
class LoginController extends Controller {
   
  
    public function login(Request $request) {
  
    if (Auth::check()) {
        return redirect()->route('admin.index');
    }

    $settings = WebSettings::first();
    
    return view('admin.auth.login', compact('settings'));
}

  


public function checkLogin(Request $request)
{
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required'
    ]);


    $remember = $request->boolean('remember_me');


    if(
        Auth::attempt(
            [
                'email' => $request->email,
                'password' => $request->password,
                'status' => 'Active'
            ],
            $remember
        )
    ){

        $request->session()->regenerate();

        $user = Auth::user();


        if($remember){
            Cookie::queue('email', $request->email, 60*24*30);
            Cookie::queue('password', $request->password, 60*24*30);
            Cookie::queue('remember_me', true, 60*24*30);
        } else {
            Cookie::queue(Cookie::forget('email'));
            Cookie::queue(Cookie::forget('password'));
            Cookie::queue(Cookie::forget('remember_me'));
        }


        return response()->json([
            'status'=>true,
            'message'=>'Admin login successful!'
        ]);
    }


    return response()->json([
        'status'=>false,
        'message'=>'Invalid admin credentials.'
    ],401);
}







    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.auth.login')->with('success', 'Logout successful!');
    }



}
