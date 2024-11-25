<div class="chat_topbar">
    <div class="topbar_chat_title">
        <div class="topbar_chat_username">
            <span class="topbar_username">
                @isset($chat_details)
                    @isset($chat_details->details)
              
                        {{$chat_details->details->username}}
                    @endisset
                @endisset
            </span>
            <span class="topbar_last_online_time">{{ __('chat.last_online') }} (10:10)</span>
        </div>

        <div class="chat_buttons">
            <span class="material-symbols-outlined" id="search_btn">search</span>
            <span class="material-symbols-outlined">call</span>
            <span class="material-symbols-outlined">more_vert</span>
        </div>

    </div>

    <div class="topbar_chat_buttons">
        <div class="topbar_buttons">
            <div class="topbar_message_buttons">
                <input type="button" value="{{ __('chat.forward') }}">
                <input type="button" value="{{ __('chat.delete') }}" id="chat-topbar-delete-selected-messages">
            </div>
            <input id="unselected_all_message" type="button" value="{{ __('chat.cancel') }}">
        </div>
    </div>
</div>