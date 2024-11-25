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
                <span class="material-symbols-outlined modal-close" onclick="closeModal(this)">close</span>
            </div>
            
            
        </div>


        <div id="main-page" class="main-page">
            <span>
                Никнейм
                <input type="text" name="nickname" id="nickname" value="{{$nickname}}">
            </span>

            <span class="modal-close" onclick="saveNickname(this)">Сохранить</span>
        </div>
    </div>
</div>