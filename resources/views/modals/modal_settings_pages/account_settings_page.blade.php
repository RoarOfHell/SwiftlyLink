<div id="my-account-page" class="account_settings page hide">
    <div class="settings_user_profile">
        <div class="settings_user_image" onclick="openCrop()">
            <div class="hover_change_avatar">
                <span class="material-symbols-outlined">photo_camera</span>
            </div>
            @if(isset($user_details))
            <img src="{{ $user_details->avatar_path }}" alt="">
            @else
            <span class="material-symbols-outlined settings_user_icon">account_circle</span>
            @endif
        </div>

        <div name="modal_nickname" class="username">
        @if(isset($user))
                        {{$user_details->nickname}}
                    @else
                        NAN
                    @endif
        </div>
    </div>

    <div class="settings_user_details">
        <div class="setting_row" onclick="openUsernameSettings()">
            <div class="setting_left">
                <span class="material-symbols-outlined">account_circle</span>
                <span class="setting_name">Username</span>
            </div>
            <div class="setting_right">
                <span name="modal_nickname">
                    @if(isset($user))
                        {{$user_details->nickname}}
                    @else
                        NAN
                    @endif
                </span>
            </div>
        </div>

        <div class="setting_row" onclick="openTagSettings()">
            <div class="setting_left">
                <span class="material-symbols-outlined">account_circle</span>
                <span class="setting_name">Tag</span>
            </div>
            <div class="setting_right">
                <span name="modal_tag">
                    @if(isset($user))
                        {{'@' . $user_details->tag}}
                    @else
                    @NAN
                    @endif
                </span>
            </div>
        </div>

        <div class="setting_row">
            <div class="setting_left">
                <span class="material-symbols-outlined">account_circle</span>
                <span class="setting_name">Birthday</span>
            </div>
            <div class="setting_right">
                <span>10-10-2020</span>
            </div>
        </div>
    </div>
</div>