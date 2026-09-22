<?php
namespace App\Http\Controllers\Api\V1\Customer;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\CustomerSurvey;
use App\Models\Customer;
use App\Models\Survey;
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

        // survey ka amount fetch karo 
        $surveyDetails = Survey::find($request->survey_id);

        $survey = CustomerSurvey::create([ 
            'customer_id' => $request->customer_id,
            'survey_id' => $request->survey_id, 
            'latitude' => trim($request->latitude),
            'longitude' => trim($request->longitude), 
            'address' => trim($request->address), 
            'survey_date' => $request->survey_date,  
            'survey_time' => $request->survey_time,
            'amount' => $surveyDetails->amount ?? 0, 
            'survey_name' => $surveyDetails->name ?? null, 
            'status' => 'Pending', 
            'payment_status' => 'pending',
        ]); 


        return response()->json([  
            'status' => true,
            'message' => 'Survey submitted successfully',
            'customer_survey_id' => $survey->id, 
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

        $query = CustomerSurvey::with(['survey', 'vendor', 'order'])->where('customer_id', $request->customer_id);

        if (!empty($request->status)) {
            $query->where('status', $request->status);
        }

        $query = $query->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);

        $data = collect($query->items())->map(function ($record) {
            $order_id = null;
            if (strtolower($record->payment_status) === 'success' || strtolower($record->payment_status) === 'paid') {
                $order_id = $record->order ? $record->order->id : null;
            }

            return [
                'id' => $record->id,   
                'order_id' => $order_id,
                'survey_name' => $record->survey_name ?? ($record->survey->name ?? null),
                'image' => !empty($record->survey->image) ? asset($record->survey->image) : null,
                'latitude' => $record->latitude,
                'longitude' => $record->longitude, 
                'amount' => $record->amount,  
                'survey_date' => $record->survey_date ? date('d-m-Y', strtotime($record->survey_date)) : null,
                'survey_time' => $record->survey_time ? date('h:i A', strtotime($record->survey_time)) : null,
                'address' => $record->address,
                'reject_reason' => $record->cancel_reason,
                'status' => $record->status,
                'payment_status' => $record->payment_status,
                'vendor_name' => $record->vendor ? $record->vendor->name : null,
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