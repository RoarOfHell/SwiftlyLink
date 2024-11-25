<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Messages;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chatId;
    public $senderId;
    public $message;
    public $unread_message_count;
    public $created_at;
    public $message_id;
    public $avatar_path;

    public function __construct($chatId, $senderId, $message, $message_id, $created_at)
    {
        $this->chatId = $chatId;
        $this->senderId = $senderId;
        $this->message = $message;
        $this->unread_message_count = DB::table('messages')->where('messages.chat_id', $chatId)->where('messages.sender_id', '=', $senderId)->where('messages.status_id', 2)->select('messages.id')->get();
        $this->created_at = $created_at;
        $this->message_id = $message_id;
        $this->avatar_path = DB::table('user_details')->where('user_id', '=', $senderId)->select('avatar_path')->first()->avatar_path;
    }

    public function broadcastOn()
    {
        return new PrivateChannel("chat.{$this->chatId}");
    }
}
