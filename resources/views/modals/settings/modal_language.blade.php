<link rel="stylesheet" href="https://swiftlylink.ru/css/modals/modal_language.css">

<div id="new-modal" class="modal no-select">
    <div class="modal-content">
        <div class="title-block">
            <span class="modal-title">Язык</span>
            <span class="material-symbols-outlined modal-close" onclick="closeModal(this)">close</span>
        </div>

        <div class="functions">
            <div class="function">
                <span>Показать кнопку "Перевести"</span>
                <input type="checkbox" name="show_btn_translate" id="show_btn_translate">
            </div>

            <div class="function">
                <span>Переводить чаты целиком</span>
                <input type="checkbox" name="translate_all_chats" id="translate_all_chats">
            </div>
        </div>

        <div class="language_settings">
            <input type="text" name="search_language" id="search_language">
            <div class="language_list">
                <div class="language-element" onclick="switchLanguage(this)">
                    <input type="radio" name="language" value="en" checked>
                    <div class="element-language">
                        <span class="language-name-for-country">English</span>
                        <span class="language-name">English</span>
                    </div>
                </div>
                <div class="language-element" onclick="switchLanguage(this)">
                    <input type="radio" name="language" value="ru">
                    <div class="element-language">
                        <span class="language-name-for-country">Русский</span>
                        <span class="language-name">Russian</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>