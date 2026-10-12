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
        if ($vendor) {
            $vendor->load('category');
        }
        return view('vendor.profile.profile', compact('page_title', 'vendor'));
    }

    public function save(Request $request)
    {
        $vendor = Auth::guard('vendor')->user();
        
        $request->validate([
            'name' => 'required|string',
            'phone_no' => 'required|min:10|max:10|unique:vendors,phone_no,' . $vendor->id,
            'gst_no' => 'required|string|max:50|unique:vendors,gst_no,' . $vendor->id,
            'pan_no' => 'required|string|max:20|unique:vendors,pan_no,' . $vendor->id,
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'proof_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $vendor->name = $request->name;
        $vendor->phone_no = $request->phone_no;
        $vendor->gst_no = strtoupper(trim($request->gst_no));
        $vendor->pan_no = strtoupper(trim($request->pan_no));

        if ($request->hasFile('profile_image')) {
            $fileName = $request->file('profile_image');
            $uploaded = uploadImage(
                $fileName,
                'vendor',
                $request->input('old_profile_image')
            );
            $vendor->profile_image = $uploaded['image'] ?? '';
        }

        if ($request->hasFile('proof_image')) {
            $fileName = $request->file('proof_image');
            $uploaded = uploadImage(
                $fileName,
                'vendor/kyc',
                $request->input('old_proof_image')
            );
            $vendor->proof_image = $uploaded['image'] ?? '';
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
