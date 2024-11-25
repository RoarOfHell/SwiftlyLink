<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use App\Models\Messages;

class MessageDeleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chatId;
    public $message_id;
    public $unread_message_count;
    public $action_sender_id;
    public $created_at;
    public $message;

    public function __construct($chatId, $message_id, $action_sender_id)
    {
        $this->chatId = $chatId;
        $this->action_sender_id = $action_sender_id;
        $this->unread_message_count = DB::table('messages')->where('messages.chat_id', $chatId)->where('messages.sender_id', '=', $action_sender_id)->where('messages.status_id', 2)->select('messages.id')->get();

        $lastMessage = DB::table('messages')->join('chat_members', 'chat_members.user_id', '!=', 'messages.sender_id')
    ->where('messages.chat_id', $chatId)
    ->whereRaw("messages.created_at = (SELECT MAX(created_at) FROM messages WHERE chat_id = ?)", [$chatId])
    ->select('messages.id', 'messages.created_at', 'chat_members.user_id as recived_id')
    ->first();

        if($lastMessage){
            $this->message_id = $message_id;
            $this->created_at = $lastMessage->created_at;
            $this->message = Messages::receiveMessage($lastMessage->id, $lastMessage->recived_id);
            $this->message = mb_convert_encoding($this->message, 'UTF-8', 'UTF-8');
        }
        else{
            $this->message_id = $message_id;
            $this->created_at = "";
            $this->message = "";
            $this->message = "";
        }
        
    }

    public function broadcastOn()
    {
        return new PrivateChannel("chat.{$this->chatId}");
    }
}
