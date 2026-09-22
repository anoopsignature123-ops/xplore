<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\CustomerSurvey;
use App\Services\ChatService;
use App\Models\WebSettings;
use Illuminate\Support\Facades\Auth;
use App\Services\FirebaseService;

class ChatController extends Controller
{
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    public function chatPage($id)
    {
        $vendor_id = Auth::guard('vendor')->user()->id;
        $survey = CustomerSurvey::with('customer')->where('id', $id)->where('vendor_id', $vendor_id)->firstOrFail();
        
        $page_title = 'Chat - ' . ($survey->customer->name ?? 'Customer');
        return view('vendor.my-survey.chat', compact('page_title', 'survey'));
    }

    public function getChatHistory($id) 
    {
        $vendor_id = Auth::guard('vendor')->user()->id;
        $survey = CustomerSurvey::where('id', $id)->where('vendor_id', $vendor_id)->first();
        
        if (!$survey) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }

        $pageNo = request()->input('page_no', 1);
        $perPage = request()->input('per_page_record', 10);
  
        $chatService = new ChatService();
        $chats = $chatService->getChatHistory($id, $perPage, $pageNo);

        return response()->json([ 
            'status' => true,
            'data' => $chats->getCollection()->map(function ($chat) {
                return [
                    'id' => $chat->id,
                    'sender_type' => $chat->sender_type,
                    'message' => $chat->message,
                    'attachment_url' => $chat->attachment_path ? asset($chat->attachment_path) : null,
                    'attachment_type' => $chat->attachment_type,
                    'created_at' => $chat->created_at->format('M d, Y h:i A'),
                    'is_me' => $chat->sender_type === 'vendor'
                ];
            }),
            'current_page' => $chats->currentPage(),
            'last_page' => $chats->lastPage(), 
        ]);
    }

    public function sendChatMessage(Request $request, $id)
    {
        $vendor = Auth::guard('vendor')->user();
        $vendor_id = $vendor->id;
        $survey = CustomerSurvey::with('customer')->where('id', $id)->where('vendor_id', $vendor_id)->first();
        
        if (!$survey) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }

        if (strtolower($survey->status) === 'completed') {
            return response()->json(['status' => false, 'message' => 'Survey is already completed. You cannot send more messages.'], 403);
        }

        $request->validate([
            'message' => 'nullable|string',
            'file' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,pdf|max:10240',
        ]);

        if (!$request->filled('message') && !$request->hasFile('file')) {
            return response()->json(['status' => false, 'message' => 'Message or file is required.'], 422);
        }

        $chatService = new ChatService();
        $chat = $chatService->sendMessage($id, 'vendor', $vendor_id, $request->message, $request->file('file'));

        // Push Notification to Customer
        if ($survey->customer && $survey->customer->status === 'Active' && !empty($survey->customer->fcm_token) && !empty($survey->customer->device_id)) {
            try {
                $title = "New Message from " . ($vendor->name ?? 'Vendor');
                 
                $body = "You have received a new message."; 
                if ($request->filled('message')) {
                    $body = substr($request->message, 0, 50) . (strlen($request->message) > 50 ? '...' : '');
                } elseif ($request->hasFile('file')) {
                    $body = "Sent an attachment."; 
                } 

                 $settings = WebSettings::select('logo')->first();
                 $imageUrl = $settings->logo ? asset($settings->logo)  :  null;
 
                $this->firebaseService->sendNotificationToMultiple( 
                    [$survey->customer->fcm_token],
                    $title,
                    $body, 
                    $imageUrl,
                    ['type' => 'chat_message', 'survey_id' => (string)$survey->id]
                );
            } catch (\Exception $e) {
                \Log::error('Firebase Chat Notification Error: ' . $e->getMessage());
            }
        }

        return response()->json([
            'status' => true,
            'data' => [
                'id' => $chat->id,
                'sender_type' => $chat->sender_type,
                'message' => $chat->message,
                'attachment_url' => $chat->attachment_path ? asset($chat->attachment_path) : null,
                'attachment_type' => $chat->attachment_type,
                'created_at' => $chat->created_at->format('M d, Y h:i A'),
                'is_me' => true
            ]  
        ]);
    } 

    public function markAsComplete($id)
    {
        $vendor_id = Auth::guard('vendor')->user()->id;
        $survey = CustomerSurvey::where('id', $id)->where('vendor_id', $vendor_id)->first();
        
        if (!$survey) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }

        $survey->status = 'Completed';
        $survey->completed_at = now();
        $survey->save();

        return response()->json(['status' => true, 'message' => 'Survey marked as completed successfully.']);
    }
}
