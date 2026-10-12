<?php
namespace App\Http\Controllers\Api\V1\Customer;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\CustomerSurvey;
use App\Models\Customer;
use App\Models\Survey;
use App\Models\WebSettings;
use Illuminate\Support\Facades\Validator;

class SurveyController extends Controller {

    public function submitSurvey(Request $request)
    { 
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'survey_id' => 'required|exists:surveys,id',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
            'address' => 'required|string',
            'survey_date' => 'required|date_format:Y-m-d', 
            'survey_time' => 'required|date_format:H:i:s'
        ]);   
  
        if ($validator->fails()) {  
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        } 

        $settings = WebSettings::first();
        $bookingPercentage = (float) ($settings->survey_booking_percentage ?? 40.00);

        // survey details fetch karo 
        $surveyDetails = Survey::find($request->survey_id);
        $amount = (float) ($surveyDetails->amount ?? 0);
        $discountAmount = (float) ($surveyDetails->discount_amount ?? 0);
        $finalAmount = (float) ($surveyDetails->final_amount ?? max(0, $amount - $discountAmount));

        $advanceAmount = round(($finalAmount * $bookingPercentage) / 100, 2);
        $remainingAmount = max(0, $finalAmount - $advanceAmount);

        $survey = CustomerSurvey::create([ 
            'customer_id' => $request->customer_id,
            'survey_id' => $request->survey_id, 
            'latitude' => trim($request->latitude),
            'longitude' => trim($request->longitude), 
            'address' => trim($request->address), 
            'survey_date' => $request->survey_date,  
            'survey_time' => $request->survey_time,
            'amount' => $amount,
            'discount_amount' => $discountAmount,
            'final_amount' => $finalAmount,
            'booking_percentage' => $bookingPercentage,
            'advance_amount' => $advanceAmount,
            'remaining_amount' => $remainingAmount,
            'paid_amount' => 0,
            'survey_name' => $surveyDetails->name ?? null, 
            'status' => 'Pending', 
            'payment_status' => 'pending',
        ]); 


        return response()->json([  
            'status' => true,
            'message' => 'Survey submitted successfully',
            'customer_survey_id' => $survey->id, 
            'advance_amount' => $advanceAmount,
            'remaining_amount' => $remainingAmount,
            'booking_percentage' => $bookingPercentage,
        ]);
    } 


    public function mySurveyList(Request $request)  
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'page_no' => 'nullable|integer|min:1',
            'page_per_record' => 'nullable|integer|min:1',
            'status' => 'nullable|string|in:Pending,Ongoing,Completed,Rejected'
        ]); 

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $page = $request->page_no ?? 1;
        $perPage = $request->page_per_record ?? 10;

        $query = CustomerSurvey::with(['survey', 'vendor.category', 'order'])->where('customer_id', $request->customer_id);

        if (!empty($request->status)) {
            $query->where('status', $request->status);
        }

        $query = $query->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);

        $data = collect($query->items())->map(function ($record) {
            $order_id = null;
            if (strtolower($record->payment_status) === 'success' || strtolower($record->payment_status) === 'paid') {
                $order_id = $record->order ? $record->order->id : null;
            }

            $bookingPct = (float) ($record->booking_percentage ?? 40.00);
            $finalAmt = (float) ($record->final_amount ?? ($record->amount - ($record->discount_amount ?? 0)));
            $advAmt = (float) ($record->advance_amount > 0 ? $record->advance_amount : round(($finalAmt * $bookingPct) / 100, 2));
            $remAmt = (float) ($record->remaining_amount > 0 ? $record->remaining_amount : max(0, $finalAmt - $advAmt));

            $openHours = (float) (WebSettings::first()->survey_open_hours ?? 3.00);
            $expiresAt = \Carbon\Carbon::parse($record->created_at)->addHours($openHours);
            $minsLeft = max(0, \Carbon\Carbon::now()->diffInMinutes($expiresAt, false));

            return [
                'id' => $record->id,   
                'order_id' => $order_id,
                'survey_name' => $record->survey_name ?? ($record->survey->name ?? null),
                'image' => !empty($record->survey->image) ? asset($record->survey->image) : null,
                'latitude' => $record->latitude,
                'longitude' => $record->longitude, 
                'amount' => (float) $record->amount,
                'discount_amount' => (float) ($record->discount_amount ?? 0),
                'final_amount' => $finalAmt,
                'booking_percentage' => $bookingPct,
                'advance_amount' => $advAmt,
                'remaining_amount' => $remAmt,
                'paid_amount' => (float) ($record->paid_amount ?? 0),
                'survey_date' => $record->survey_date ? date('d-m-Y', strtotime($record->survey_date)) : null,
                'survey_time' => $record->survey_time ? date('h:i A', strtotime($record->survey_time)) : null,
                'address' => $record->address,
                'reject_reason' => $record->cancel_reason,
                'status' => $record->status,
                'payment_status' => $record->payment_status,
                'is_vendor_assigned' => !empty($record->vendor_id),
                'is_open_for_vendor_acceptance' => (empty($record->vendor_id) && $minsLeft > 0),
                'open_time_remaining_mins' => (empty($record->vendor_id) && $minsLeft > 0) ? $minsLeft : 0,
                'vendor_id' => $record->vendor_id,
                'vendor_name' => $record->vendor ? $record->vendor->name : null,
                'vendor_category_id' => $record->vendor ? $record->vendor->vendor_category_id : null,
                'vendor_category_name' => ($record->vendor && $record->vendor->category) ? $record->vendor->category->name : null,
                'vendor_email' => $record->vendor ? $record->vendor->email_id : null,
                'vendor_phone' => $record->vendor ? $record->vendor->phone_no : null,
                'vendor_profile_pic' => ($record->vendor && !empty($record->vendor->profile_image)) ? asset($record->vendor->profile_image) : null,
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Surveys fetched successfully',
            'data' => $data,
        ]);
    }
}