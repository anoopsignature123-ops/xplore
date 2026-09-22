<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerSurvey;
use App\Services\ChatService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    protected $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    /**
     * Get chat history for a survey.
     */ 
    public function getHistory(Request $request, $surveyId)
    { 
        $validator = Validator::make($request->all(), [ 
            'customer_id' => 'required|exists:customers,id',
            'page_no'          => 'nullable|string|min:1', 
            'per_page_record'  => 'nullable|string|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()], 422);
        }

        $customerId = $request->customer_id;

        // Check if survey belongs to customer
        $survey = CustomerSurvey::where('id', $surveyId)
            ->where('customer_id', $customerId)
            ->first();

        if (!$survey) {
            return response()->json(['status' => false, 'message' => 'Survey not found or unauthorized.'], 404);
        }

        $pageNo = $request->input('page_no', 1);
        $perPage = $request->input('per_page_record', 10);

        $chats = $this->chatService->getChatHistory($surveyId, $perPage, $pageNo);

        $formattedChats = $chats->getCollection()->map(function ($chat) {
            return [
                'id' => $chat->id,
                'sender_type' => $chat->sender_type,
                'message' => $chat->message,
                'attachment_url' => $chat->attachment_path ? asset($chat->attachment_path) : null,
                'attachment_type' => $chat->attachment_type,
                'created_at' => $chat->created_at->format('M d, Y h:i A'), 
                'is_me' => $chat->sender_type === 'customer'
            ];
        });

        return response()->json([
            'status' => true, 
            'message' => 'Chat history fetched successfully.',
            'data' => $formattedChats
        ], 200);
    }

    /**
     * Send a message in a survey chat. 
     */
    public function sendMessage(Request $request, $surveyId)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'message' => 'nullable|string',
            'file' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,pdf|max:10240', // max 10MB
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()], 422);
        }

        if (!$request->filled('message') && !$request->hasFile('file')) {
            return response()->json(['status' => false, 'message' => 'Message or file is required.'], 422);
        }

        $customerId = $request->customer_id;

        // Check if survey belongs to customer
        $survey = CustomerSurvey::where('id', $surveyId)
            ->where('customer_id', $customerId)
            ->first();

        if (!$survey) {
            return response()->json(['status' => false, 'message' => 'Survey not found or unauthorized.'], 404);
        }

        $chat = $this->chatService->sendMessage(
            $surveyId,
            'customer',
            $customerId,
            $request->message,
            $request->file('file')
        );

        return response()->json([
            'status' => true,
            'message' => 'Message sent successfully.',
            'data' => [
                'id' => $chat->id,
                'sender_type' => $chat->sender_type,
                'message' => $chat->message,
                'attachment_url' => $chat->attachment_path ? asset($chat->attachment_path) : null,
                'attachment_type' => $chat->attachment_type,
                'created_at' => $chat->created_at->format('Y-m-d H:i:s'),
                'is_me' => true
            ]
        ], 201);
    }
}
