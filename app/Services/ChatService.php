<?php

namespace App\Services;

use App\Models\SurveyChat;
use Illuminate\Support\Facades\Storage;
use App\Events\SurveyMessageSent;

class ChatService
{
    /**
     * Get chat history for a specific survey (Paginated).
     */
    public function getChatHistory($customerSurveyId, $perPage = 10, $pageNo = 1)
    {
        return SurveyChat::where('customer_survey_id', $customerSurveyId)->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page_no', $pageNo);
    }

    /**
     * Send a message and handle attachments.
     */
    public function sendMessage($customerSurveyId, $senderType, $senderId, $message = null, $file = null)
    {
        $attachmentPath = null;
        $attachmentType = null;

        if ($file) {
            $extension = strtolower($file->getClientOriginalExtension());
            $attachmentType = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']) ? 'image' : 'pdf';
            
            // Store file
            $path = $file->store('chat_attachments', 'public');
            $attachmentPath = 'storage/' . $path;
        }

        $chat = SurveyChat::create([
            'customer_survey_id' => $customerSurveyId,
            'sender_type' => $senderType,
            'sender_id' => $senderId,
            'message' => $message,
            'attachment_path' => $attachmentPath,
            'attachment_type' => $attachmentType,
        ]);

        // Trigger Broadcast Event safely
        try {
            broadcast(new SurveyMessageSent($chat))->toOthers();
        } catch (\Exception $e) {
            // Ignore broadcast exception if WebSocket server is unreachable.
            // The message is already saved in the database.
            \Illuminate\Support\Facades\Log::error('WebSocket Broadcasting Failed: ' . $e->getMessage());
        }

        return $chat;
    }
}
