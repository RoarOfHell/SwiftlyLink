import { Chat } from "/js/chat/Chats.js";

export class Search {
    constructor() {
        this.timeoutId = null;
    }

    async search_users(searched_text){
        try {
            const response = await fetch(`https://swiftlylink.ru/api/search_users?search=${searched_text}`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                },
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const result = await response.json();
            return result;
        } catch (error) {
            console.error('Error setting user offline:', error);
        }
    }

    debounceSearchUsers(query, delay = 300) {
        // Очищаем предыдущий таймер
        clearTimeout(this.timeoutId);

        // Устанавливаем новый таймер
        return new Promise((resolve) => {
            // Устанавливаем новый таймер
            this.timeoutId = setTimeout(async () => {
                const result = await this.search_users(query);
                resolve(result);  // Возвращаем результат через resolve
            }, delay);
        });
    }

    showSearchUsers(searchText){
        var search_container = document.querySelector('.sidebar-search-content');
        if(!searchText){
            search_container.innerHTML = '';
            search_container.classList.remove('show');
        }
        else{
            search_container.classList.add('show');

            this.debounceSearchUsers(searchText, 500).then(f => {
                search_container.innerHTML = '';

                if(f.chat_users.length != 0){
                    var span_chats = document.createElement('span');
                    span_chats.innerHTML = 'Чаты';
                    search_container.append(span_chats);
                    f.chat_users.forEach(element => {
                        var div = document.createElement('div');
                        div.innerHTML = this.getChatCard(element);
                        search_container.append(div);
                    });
                }
                
                var span_users = document.createElement('span');
                span_users.innerHTML = 'Пользователи';
                search_container.append(span_users);
                f.searched_users.forEach(element => {
                    var div = document.createElement('div');
                    div.addEventListener('click', function(){
                        Chat.getNewTempChat(element.id);
                    })
                    div.innerHTML = this.getUserCard(element);
                    search_container.append(div);
                });
            });
        }
        
    }

    getChatCard(chat_details){
        return `
        <div class="message-card no-select" id="${chat_details.id}">
            <div class="avatar-container">
                <div class="avatar">
                    ${(chat_details.avatar_path == null ? `<span class="material-symbols-outlined">
                    person
                    </span>` : `<img src="${chat_details.avatar_path}" alt="">`)}
                    
                </div>
                
            </div>
            <div class="message-info">
                <div class="message-header">
                    <span class="nickname">${chat_details.username ?? ''}</span>
                    <span class="message-time">${chat_details.last_message_time ?? ''}</span>
                </div>
                <div class="message-text-container">
                    <div class="message-text">${chat_details.last_message ?? ''}</div>
                    <div class="message-count ${chat_details.count_message_noread ?? 'hide'}">${chat_details.count_message_noread ?? ''}</div>
                </div>
            </div>
        </div>
        `;
    }

    getUserCard(user_details){
        return `
        <div class="message-card no-select" id="${user_details.id}">
            <div class="avatar-container">
            ${(user_details.avatar_path == null ? `<span class="material-symbols-outlined">
                person
                </span>` : `<img src="${user_details.avatar_path}" alt="">`)}
                
            </div>
            <div class="message-info">
                <div class="message-header">
                    <span class="nickname">${user_details.username ?? ''}</span>
                </div>
                <div class="message-text-container">
                    <div class="message-text">${user_details.last_online ?? ''}</div>
                </div>
            </div>
        </div>
        `;
    }
}