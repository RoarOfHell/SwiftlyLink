<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

<div>
    <ul>
        <li id="reply">
            <div class="context_menu_item">
                <div class="context_menu_icon"><span class="material-symbols-outlined">reply</span></div>
                <div class="context_menu_text">{{ __('chat.answer') }}</div>
            </div>
        </li>
        <li id="edit">
            <div class="context_menu_item">
                <div class="context_menu_icon"><span class="material-symbols-outlined">edit</span></div>
                <div class="context_menu_text">{{ __('chat.edit') }}</div>
            </div>
        </li>
        <li id="keep">
            <div class="context_menu_item">
                <div class="context_menu_icon"><span class="material-symbols-outlined">keep</span></div>
                <div class="context_menu_text">{{ __('chat.pin') }}</div>
            </div>
        </li>
        <li id="content_copy">
            <div class="context_menu_item">
                <div class="context_menu_icon"><span class="material-symbols-outlined">content_copy</span></div>
                <div class="context_menu_text">{{ __('chat.copy_text') }}</div>
            </div>
        </li>
        <li id="forward">
            <div class="context_menu_item">
                <div class="context_menu_icon"><span class="material-symbols-outlined">forward</span></div>
                <div class="context_menu_text">{{ __('chat.forward') }}</div>
            </div>
        </li>
        <li id="delete">
            <div class="context_menu_item">
                <div class="context_menu_icon"><span class="material-symbols-outlined">delete</span></div>
                <div class="context_menu_text">{{ __('chat.delete') }}</div>
            </div>
        </li>
        <li id="selection">
            <div class="context_menu_item">
                <div class="context_menu_icon"><span class="material-symbols-outlined">check_circle</span></div>
                <div class="context_menu_text">{{ __('chat.select') }}</div>
            </div>
        </li>
    </ul>
    <div class="time_sendet_container">
        <span class="material-symbols-outlined context_menu_icon time_icon">done_all</span>
        <span class="time_sendet_text">Вчера 10:30</span>
    </div>
</div>
