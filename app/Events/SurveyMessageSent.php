<?php

namespace App\Events;

use App\Models\SurveyChat;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SurveyMessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chat;

    /**
     * Create a new event instance.
     */
    public function __construct(SurveyChat $chat)
    {
        $this->chat = $chat;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        // Broadcast on a private channel specific to this survey
        return [
            new PrivateChannel('survey.chat.' . $this->chat->customer_survey_id),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'message.sent';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->chat->id,
            'customer_survey_id' => $this->chat->customer_survey_id,
            'sender_type' => $this->chat->sender_type,
            'sender_id' => $this->chat->sender_id,
            'message' => $this->chat->message,
            'attachment_url' => $this->chat->attachment_path ? asset($this->chat->attachment_path) : null,
            'attachment_type' => $this->chat->attachment_type,
            'created_at' => $this->chat->created_at->format('M d, Y h:i A'),
        ];
    }
}
