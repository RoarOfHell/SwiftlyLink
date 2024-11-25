<link rel="stylesheet" href="/css/components/messages.css">
<link rel="stylesheet" href="/css/components/context_menu.css">

<div class="main_messages_container">
    <div class="messages_container">
        @isset($chat_details)

            @isset($chat_details->messages)
                @foreach($chat_details->messages as $message)
    
                <div class="user_message">
                    <div class="user_icon">
                        <div class="icon">
                            @if(isset($message->avatar_path))
                            <img class="icon" src="{{ $message->avatar_path }}" alt="">
                            @else
                            <span class="icon" class="material-symbols-outlined settings_user_icon" style="font-size: 32px">account_circle</span>
                            @endif
                        </div>
                    </div>
                    <div class="user_message_content {{ $message->sender_id == $chat_details->details->user_id ? 'other' : '' }} target" id="{{$message->id}}">
                        <span class="message">{{\App\Models\Messages::receiveMessage($message->id, $message->recipient_id)}}</span>
                        <span class="send_time">{{$message->created_at}}</span>
                    </div>
                </div>
    
                @endforeach
            @endisset
        @endisset
    </div>
</div>

<script src="/js/pages/messages.js"></script>
