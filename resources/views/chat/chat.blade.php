<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="yandex-verification" content="a176b12ae086b131" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="/favicon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/css/chat/chat.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    @vite('resources/js/app.js')
    <title>messenger</title>
</head>
<body>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
    @method('POST')
</form>

   <div class="main-container">
        <div id="menu" class="menu-body no-select">
            <div class="menu-content">
                <div class="logo-content">
                    <div class="logo">Swiftlylink</div>
                </div>
                <div class="menu-user-info">
                    <div class="user-icon">
                        @if(isset($user_details))
                        <img src="{{ $user_details->avatar_path }}" alt="">
                        @else
                        <span class="material-symbols-outlined settings_user_icon">account_circle</span>
                        @endif
                    </div>
                    <div class="username">
                        <span name="modal_nickname">
                        @if(isset($user_details))
                            {{$user_details->nickname}}
                        @endif
                        </span>
                    </div>
                </div>

                <div class="menu-tools-content">
                    <div class="menu-tool">
                        <div class="tool-icon">
                            <span class="material-symbols-outlined">
                                group
                            </span>
                        </div>

                        <div class="tool-title">
                        {{ __('side_bar_menu.create_group') }}
                        </div>
                    </div>

                    <div class="menu-tool">
                        <div class="tool-icon">
                            <span class="material-symbols-outlined">
                                group
                            </span>
                        </div>

                        <div class="tool-title">
                        {{ __('side_bar_menu.create_channel') }}
                        </div>
                    </div>

                    <div class="menu-tool">
                        <div class="tool-icon">
                            <span class="material-symbols-outlined">
                            account_circle
                            </span>
                        </div>

                        <div class="tool-title">
                        {{ __('side_bar_menu.contacts') }}
                        </div>
                    </div>

                    <div class="menu-tool">
                        <div class="tool-icon">
                            <span class="material-symbols-outlined">
                            call
                            </span>
                        </div>

                        <div class="tool-title">
                        {{ __('side_bar_menu.calls') }}
                        </div>
                    </div>

                    <div id="settings_btn" class="menu-tool">
                        <div class="tool-icon">
                            <span class="material-symbols-outlined">
                            settings
                            </span>
                        </div>

                        <div class="tool-title">
                        {{ __('side_bar_menu.settings') }}
                        </div>
                    </div>
                </div>

                <div class="other-project">
                    <div class="menu-tool" id="go_to_anime">
                        <div class="tool-icon">
                        <img src="https://img.icons8.com/ios-filled/50/ffffff/anime.png" alt="Аниме">
                        </div>

                        <div class="tool-title">
                        {{ __('side_bar_menu.anime') }}
                        </div>
                    </div>

                    <div class="menu-tool">
                        <div class="tool-icon">
                        <img src="https://img.icons8.com/ios-filled/50/ffffff/video.png" alt="Видео">
                        </div>

                        <div class="tool-title">
                        {{ __('side_bar_menu.video') }}
                        </div>
                    </div>
                </div>
            </div>    
        </div>

        <div class="sidebar">
            <div class="tools-sidebar">
                <div class="menu click no-select" id="menu_btn">
                    <span class="material-symbols-outlined">
                        menu
                    </span>
                </div>

                <div class="folders">
                    <div class="folder click no-select">
                        <span class="material-symbols-outlined tools-icon">
                            forum
                        </span>
                        <span class="title">
                        {{ __('side_bar_menu.all_chats') }}
                        </span>
                    </div>


                    <div class="folder click no-select">
                        <span class="material-symbols-outlined tools-icon">
                        format_list_bulleted
                        </span>
                        <span class="title">
                        {{ __('side_bar_menu.edit') }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="chats-sidebar">
                <div class="sidebar-top">
                    <div class="search-bar">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" placeholder="{{ __('side_bar_list.search') }}" id="sidebar_search">
                    </div>
                </div>
    
                <div class="sidebar-content">
                    <div class="sidebar-chats-content">
                    @foreach ($chats as $chat)
                    <div class="message-card no-select {{isset($chat_selected) ? ($chat_selected == $chat->chat_id ? 'selected' : '') : ''}}" id="{{$chat->chat_id}}">
                        <div class="avatar-container">
                            <div class="avatar">
                                @if(isset($chat->avatar_path))
                                <img src="{{ $chat->avatar_path }}" alt="">
                                @else
                                <span class="material-symbols-outlined settings_user_icon" style="font-size: 32px">account_circle</span>
                                @endif
                            </div>
                            @include('include.user_status')
                        </div>
                        <div class="message-info">
                            <div class="message-header">
                                <span class="nickname">{{$chat->nickname}}</span>
                                <span class="message-time">{{$chat->message_time}}</span>
                            </div>
                            <div class="message-text-container">
                                <div class="message-text">{{\App\Models\Messages::receiveMessage($chat->message_id, $chat->recipient_id)}}</div>
                                <div class="message-count {{($chat->unread_message_count <= 0 ? 'hide' : '')}}">{{$chat->unread_message_count}}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    </div>
                    <div class="sidebar-search-content">
                        
                    </div>
                </div>

                
            </div>
        </div>

        @if(isset($chat_details))
        <div class="chat_container">
            <div class="topbar">
                @include('include.chat_topbar')
            </div>

            <div class="messages">
                @include('include.chat_messages')
            </div>

            <div class="bottombar">
                @include('include.chat_bottom_bar')
            </div>

                @include('include.chat_message_search')
        </div>
        @else
        <div class="chat-no-selected no-select">
            <span>{{ __('chat.choose_write') }}</span>
        </div>
        @endif

        @include('include.notifications')
   </div>
   <script src="/js/chat/chat_init.js"></script>
  
   
   <script>
    var ids = @json($chat_ids);
    var user = @json($user);
    var token = @json($token);
    var locale = @json($locale);
    var self_avatar_path = @json($user_details->avatar_path ?? "");
    var newChat;
    initChatInputs();
   </script>
   <script src="https://kit.fontawesome.com/e4b39858b6.js" crossorigin="anonymous"></script>
   <script src="/js/modals/modal-controller.js"></script>
   <script src="/js/modals/modals.js"></script>
   <script src="/js/modals/settings_modal.js"></script>
   <script type="module" src="/js/chat/chat.js"></script>
   <script src="{{ asset('js/notification.js') }}"></script>
</body>
</html>