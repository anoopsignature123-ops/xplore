<?php
namespace App\Http\Controllers\Api\V1\Customer;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\WebSettings;
use App\Models\Customer; 
use App\Traits\SendOtpTrait;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;


class LoginController extends Controller {
    use SendOtpTrait; 
 
   public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'phone_no' => 'required|digits:10', 
            'device_id' => 'required',   
            'fcm_token' => 'nullable',   
            'device_type' => 'required']   
        );

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first(), ], 422);
        }



        $customer = Customer::where('phone_no', $request->phone_no)->first();
        if (empty($customer)) {
            $customer = Customer::create([
                'phone_no' => $request->phone_no, 
                'device_id' => $request->device_id, 
                'fcm_token' => $request->fcm_token, 
                'device_type' => $request->device_type,
                'status' => 'Active', 
                ]);
        }  
        $otp = 123456;    
        // $otp = rand(100000, 999999); 
        $customer->update(['otp' => $otp, 'otp_sent_at' => Carbon::now(), ]);
        // if (!empty($request->phone_no)) {
        //      $otpRecord = $this->sendSms($request->phone_no,$customer->name ?? 'User',  $otp); 
        // } 
 
         

        // Delete only the token for the current device to prevent logging out other devices
        $customer->tokens()->where('name', $request->phone_no)->delete();
        $token = $customer->createToken($request->phone_no);
        return response()->json(['status' => true, 'message' => 'OTP sent successfully', 'token' => $token->plainTextToken]);
    } 
 

    public function matchOtp(Request $request) {
        $validator = Validator::make($request->all(), [
            'phone_no' => 'required|digits:10', 
            'otp' => 'required|digits:6',  
            'device_id' => 'nullable|string', 
            'fcm_token' => 'nullable|string'
        ]); 
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first(), ], 422);
        }
        $customer = Customer::where('phone_no', $request->phone_no)->first();
        if (empty($customer)) {
            return response()->json(['status' => false, 'message' => 'Phone number not registered', ], 404);
        }
        if ($customer->otp !== $request->otp) {
            return response()->json(['status' => false, 'message' => 'Invalid OTP', ], 401);
        }

        if ($customer->otp_sent_at->addMinutes(1)->isPast()) {
            return response()->json([
                'success' => false,
                'message' => 'OTP expired. Please resend OTP' 
            ]); 
        }


        $customer->update([
            'device_id' => $request->device_id, 
            'fcm_token' => $request->fcm_token,  
            'otp' => null
        ]);
        return response()->json(['status' => true, 'message' => 'OTP Matched Successfully', 'customer' => $this->customerResponse($customer) ]);
    }
    


    public function autoLogin(Request $request) {
        $validator = Validator::make($request->all(), [
            'device_id' => 'required',  
            'fcm_token' => 'nullable'
        ]); 
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first(), ], 422);
        }
        $customer = Customer::where('device_id', $request->device_id)->first();
        if (empty($customer)) {
            return response()->json(['status' => false, 'message' => 'You are logged out', ], 401);
        }
        $customer->update(['device_id' => $request->device_id, 'fcm_token' => $request->fcm_token]);
        // Delete only the token for the current device to prevent logging out other devices
        $customer->tokens()->where('name', $customer->phone_no)->delete();
        $token = $customer->createToken($customer->phone_no);
        return response()->json(['status' => true, 'message' => 'Auto Login successfully', 'token' => $token->plainTextToken, 'customer' => $this->customerResponse($customer) ]);
    }

 
    public function logout(Request $request) {
        $validator = Validator::make($request->all(), ['id' => 'required|string']);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first(), ], 422);
        }
        $customer = Customer::where('id', $request->id)->first();
        if (!empty($customer)) { 
            $customer->update(['device_id' => null, 'fcm_token' => null]);
            $customer->tokens()->where('name', $customer->phone_no)->delete();
        }
        return response()->json(['status' => true, 'message' => 'Logged out successfully', ]);
    }



    public function profile(Request $request) { 
        $validator = Validator::make($request->all(), [ 
            'id' => 'required', 
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first(), ], 422);
        }
        $customer = Customer::find($request->id); 
        if (empty($customer)) {
            return response()->json(['status' => false, 'message' => 'No Record Found', ], 401);
        }
       
        return response()->json(['status' => true, 'message' => 'Profile Record Fetched successfully',  'customer' => $this->customerResponse($customer) ]);
    }



    
    

public function updateProfile(Request $request)
{
    $validator = Validator::make($request->all(), [
        'id' => 'required',
        'name' => 'required|string',
        'email_id' => ['required','email',Rule::unique('customers', 'email_id')->ignore($request->id),],
        'gender' => 'required|string', 
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => $validator->errors()->first(),
        ], 422);
    }

    $customer = Customer::find($request->id);

    if (!$customer) {
        return response()->json([
            'status' => false,
            'message' => 'No Record Found',
        ], 401);
    } 

    $customer->name = $request->name;
    $customer->email_id = $request->email_id;
    $customer->gender = $request->gender;

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $uploaded = uploadImage($file, 'customer', $customer->profile_image ?? '');
        $customer->profile_image = $uploaded['image'] ?? null;
    }

    $customer->save();

    return response()->json([
        'status' => true,
        'message' => 'Profile updated successfully',
        'customer' => $this->customerResponse($customer)
    ]);
}







    public function webSettings() {
        $setting = WebSettings::first();
        $data = [
                'company_name' => !empty($setting->company_name) ? $setting->company_name : '',
                'email_id' => !empty($setting->email_id) ? $setting->email_id : '',
                'phone_no' => !empty($setting->phone_no) ? $setting->phone_no : '',
                'whatsapp_no' => !empty($setting->whatsapp_no) ? $setting->whatsapp_no : '',
                'facebook_link' => !empty($setting->facebook_link) ? $setting->facebook_link : '',
                'instagram_link' => !empty($setting->instagram_link) ? $setting->instagram_link : '',
                'twitter_link' => !empty($setting->twitter_link) ? $setting->twitter_link : '', 
                'linkedin_link' => !empty($setting->linkedin_link) ? $setting->linkedin_link : '',
                'youtube_link' => !empty($setting->youtube_link) ? $setting->youtube_link : '',
                'copyright' => !empty($setting->copyright) ? $setting->copyright : '', 
                'logo' => !empty($setting->logo) ? asset($setting->logo) : '',
                'address' => !empty($setting->address) ? $setting->address : '',
         ];
        return response()->json(['status' => true, 'message' => 'setting record fetched successfully', 'data' => $data]);
    }
 

     private function customerResponse($customer) {
        return [
            'id' => !empty($customer->id) ? $customer->id : null, 
            'name' => !empty($customer->name) ? $customer->name : null, 
            'gender' => !empty($customer->gender) ? $customer->gender : null,  
            'email_id' => !empty($customer->email_id) ? $customer->email_id : null,  
            'phone_no' => !empty($customer->phone_no) ? $customer->phone_no : null, 
            'profile_image' => !empty($customer->profile_image) ? asset($customer->profile_image) : null, 
            'status' => !empty($customer->status) ? $customer->status : null, 
        ];
    }






}