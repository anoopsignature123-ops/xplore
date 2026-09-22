<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WebSettings;
use Validator;

class WebSettingController extends Controller
{
    public function index()
    {
         $settings = WebSettings::first();
         $btn_title  = $settings ? 'Update' : 'Submit';
         $page_title = $settings ? 'Update Web Settings' : 'Add Web Settings';
         return view('admin.settings.settings',compact('page_title','btn_title','settings'));
    }

   
    public function save(Request $request)
    {
        $rules = [
            'company_name'            => 'required|string',
            'email_id'                => 'required|email', 
            'phone_no'                => 'required|string|max:10',
            'whatsapp_no'             => 'required|string|max:10',
            'facebook_link'           => 'required|url',
            'instagram_link'          => 'required|url',
            'twitter_link'            => 'required|url', 
            'youtube_link'            => 'required|url',
            'copyright'               => 'required|string',
            'address'                 => 'required|string',
            'logo'                    => 'nullable|image|mimes:jpg,jpeg,png',
            'favicon'                 => 'nullable|image|mimes:jpg,jpeg,png', 
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Fetch or create the settings record
        $settings = WebSettings::firstOrNew([]);

        // Update all basic text fields
        $fieldsToUpdate = [
            'company_name', 'email_id', 'phone_no', 'whatsapp_no', 
            'facebook_link', 'youtube_link', 'instagram_link', 'twitter_link',
            'copyright', 'address', 
        ];
        
        foreach ($fieldsToUpdate as $field) {
            $settings->$field = $request->input($field);
        }


        // Handle Logo Upload
        if ($request->hasFile('logo')) {
            $uploadResult = uploadImage($request->file('logo'), 'setting', $request->input('old_logo'));
            $settings->logo = $uploadResult['image'] ?? '';
        }

        // Handle Favicon Upload
        if ($request->hasFile('favicon')) {
            $uploadResult = uploadImage($request->file('favicon'), 'setting', $request->input('old_favicon'));
            $settings->favicon = $uploadResult['image'] ?? '';
        }

        $settings->save();

        return response()->json([
            'success' => true,
            'message' => 'Settings saved successfully.'
        ]);
    }


}
