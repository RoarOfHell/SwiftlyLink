<link rel="stylesheet" href="../../css/modals/settings_modal.css">

<div id="new-modal" class="modal no-select">
    <div class="modal-content">
        <div class="title-block">
            <div class="title-block-left">
                <div id="back" class="modal-back-btn">
                    <span class="material-symbols-outlined">arrow_back</span>
                </div>
                <span class="modal-title">{{ __('settings_modal.settings') }}</span>
            </div>
            <div class="modal-tools">
                <div class="more-actions-panel">
                    <span class="material-symbols-outlined more-actions">more_vert</span>
                    <div class="actions">
                        <div class="action">
                            <span class="material-symbols-outlined">logout</span>
                            <span class="" onclick="logout()">{{ __('settings_modal.logout') }}</span>
                        </div>
                    </div>
                </div>
                <span class="material-symbols-outlined modal-close" onclick="closeModal(this)">close</span>
            </div>
        </div>

        <div id="main-page" class="main-page">
            <div class="block-user-info">
                <div class="modal-user-info">
                    <div class="modal-user-icon">
                        @if(isset($user_details->avatar_path))
                        <img class="modal-user-avatar" src="{{ $user_details->avatar_path }}" alt="">
                        @else
                        <span  class="material-symbols-outlined modal-user-avatar" style="font-size: 32px">account_circle</span>
                        @endif
                    </div>

                    <div class="modal-user-details">
                        <span name="modal_nickname" class="modal-username">
                        @if(isset($user))
                            {{$user_details->nickname}}
                        @else
                            NAN
                        @endif
                        </span>
                        <span name="modal_tag" class="modal-username-tag">
                        @if(isset($user))
                            {{ '@' . $user_details->tag }}
                        @else
                            '@NAN'
                        @endif
                        </span>
                    </div>
                </div>
            </div>

            <div class="categories">
                <div id="my-account" class="category">
                    <span class="material-symbols-outlined">account_circle</span>
                    <span class="category-name">{{ __('settings_modal.my_account') }}</span>
                </div>

                <div id="notification-and-sounds" class="category">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="category-name">{{ __('settings_modal.notification_and_sounds') }}</span>
                </div>

                <div id="confidentiality" class="category">
                    <span class="material-symbols-outlined">lock</span>
                    <span class="category-name">{{ __('settings_modal.confidentiality') }}</span>
                </div>

                <div id="chat-settings" class="category">
                    <span class="material-symbols-outlined">chat_bubble</span>
                    <span class="category-name">{{ __('settings_modal.chat_settings') }}</span>
                </div>

                <div id="chat-folders" class="category">
                    <span class="material-symbols-outlined">folder</span>
                    <span class="category-name">{{ __('settings_modal.folders_with_chats') }}</span>
                </div>

                <div class="category" onclick="openLanguage()">
                    <span class="material-symbols-outlined">translate</span>
                    <div class="category-language">
                        <span class="category-name">{{ __('settings_modal.language') }}</span>
                        <span class="language">English</span>
                    </div>
                </div>
            </div>
        </div>

        @include('modals.modal_settings_pages.account_settings_page')

        @include('modals.modal_settings_pages.chats_settings_page')

        @include('modals.modal_settings_pages.confidentiality_settings_page')

        @include('modals.modal_settings_pages.folders_settings_page')

        @include('modals.modal_settings_pages.notification_settings_page')

        <!--<button onclick="openCrop()">Загрузить фото</button>-->
    </div>
</div>