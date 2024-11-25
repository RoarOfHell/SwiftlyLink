<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chats;
use App\Models\Messages;
use App\Events\MessageDeleted;

class MessageController extends Controller
{
    protected function remove_messages(Request $request){
        $chat_id = $request->input('chat_id');
        $user_id = $request->input('user_id');
        $message_ids = $request->input('message_ids');

        if(!$chat_id || !$user_id || !$message_ids){
            return response()->json(['message' => $message_ids, 'data' => "3123"]);
        }

        if(Chats::has_access($chat_id, $user_id)){
            Messages::whereIn('id', $message_ids)->where('chat_id', $chat_id)->delete();
            broadcast(new MessageDeleted($chat_id, $message_ids, $user_id))->toOthers();
            return response()->json(['message' => 'complited', 'data' => "complited"]);
        }

        return response()->json(['message' => '44444', 'data' => "44444"]);
    }
}
