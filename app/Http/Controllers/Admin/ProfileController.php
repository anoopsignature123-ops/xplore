<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use App\Models\WebSettings;
use Validator;

class ProfileController extends Controller
{
    public function index()
    {
         $profile = User::find(auth()->id());
         $btn_title  = $profile ? 'Update' : 'Submit';
         $page_title = $profile ? 'Update Profile' : 'Add Profile';
         return view('admin.profile.profile',compact('page_title','btn_title','profile'));
    }

    public function save(Request $request)
    {
        $rules = [
            'name'        => 'required|string', 
            'email'       => 'required|email', 
            'profile_pic' => 'nullable|image|mimes:jpg,jpeg,png',
            'new_password'=> 'nullable|min:6',
            'confirm_new_password' => 'nullable|same:new_password'
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Get first user or create new
        $profile = User::firstOrNew(['id' => auth()->id()]);

        // Fill basic fields 
        $profile->name  = $request->name;
        $profile->email = $request->email;
        
        if ($request->filled('new_password')) {
            $profile->password = Hash::make($request->new_password);
        }

        if ($request->hasFile('profile_pic')) {
            $fileName = $request->file('profile_pic');
            $uploaded = uploadImage(
                $fileName,
                'user',
                $request->input('old_profile_pic')
            );
            $profile->profile_pic = $uploaded['image'] ?? '';
        }

        $profile->save();

        return response()->json([
            'success' => true,
            'message' => 'Profile saved successfully.'
        ]);
    }

    public function changePassword(Request $request)
    {
        $rules = [
            'new_password' => 'required|min:6',
            'confirm_new_password' => 'required|same:new_password'
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $profile = User::first();
        if ($profile) {
            $profile->password = Hash::make($request->new_password);
            $profile->save();
            return response()->json([
                'success' => true,
                'message' => 'Password changed successfully.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'User not found.'
        ], 404);
    }
}
