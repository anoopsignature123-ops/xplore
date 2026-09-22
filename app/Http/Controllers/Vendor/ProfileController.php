<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index() 
    { 
        $page_title = 'Update Profile'; 
        $vendor = Auth::guard('vendor')->user();
        return view('vendor.profile.profile', compact('page_title', 'vendor'));
    }

    public function save(Request $request)
    {
        $vendor = Auth::guard('vendor')->user();
        
        $request->validate([
            'name' => 'required|string',
            'phone_no' => 'required|min:10|max:10|unique:vendors,phone_no,' . $vendor->id,
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $vendor->name = $request->name;
        $vendor->phone_no = $request->phone_no;

        if ($request->hasFile('profile_image')) {
            $fileName = $request->file('profile_image');
            $uploaded = uploadImage(
                $fileName,
                'vendor',
                $request->input('old_profile_image')
            );
            $vendor->profile_image = $uploaded['image'] ?? '';
        }

        $vendor->save();

        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully.'
        ]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|same:confirm_password',
            'confirm_password' => 'required'
        ]);

        $vendor = Auth::guard('vendor')->user();

        if (Hash::check($request->old_password, $vendor->password) || $vendor->raw_password === $request->old_password) {
            $vendor->password = Hash::make($request->new_password);
            $vendor->raw_password = $request->new_password;
            $vendor->save();

            return response()->json([
                'status' => true,
                'message' => 'Password changed successfully.'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Old password does not match.'
        ]);
    }
}
