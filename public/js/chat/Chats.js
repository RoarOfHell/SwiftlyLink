import { Message } from "./Messages.js";
import { DateTimeFormater } from "../date_time/DateTimeFormater.js";

export class Chat {
    constructor(id, chat_type_id, updated_at, created_at) {
        this.id = id,
        this.chat_type_id = chat_type_id,
        this.updated_at = updated_at,
        this.created_at = created_at
    }

    get id(){ return this._id; }

    set id(value){ 
        if(!value && value.trim() == '') return;
        this._id = value;
        return;
    }

    get chat_type_id(){ return this._chat_type_id; }

    set chat_type_id(value){
        if(!value && value.trim() == '') return;
        this._chat_type_id = value;
        return;
    }

    get updated_at(){
        return this._updated_at;
    }

    set updated_at(value){
        if(!value && value.trim() == '') return;
        this._updated_at = value;
        return;
    }

    get created_at(){
        return this._created_at;
    }

    set created_at(value){
        if(!value && value.trim() == '') return;
        this._created_at = value;
        return;
    }

    async addMessageToChat(message, context_menu_object, avatar_path){
        const main_messages_Container = document.querySelector('.messages');
        const messagesContainer = document.querySelector('.messages_container');

        var message_html = await message.get_html(context_menu_object, avatar_path);
        messagesContainer.appendChild(message_html);

        // Прокрутка вниз, чтобы увидеть новое сообщение
        main_messages_Container.scrollTop = main_messages_Container.scrollHeight;
    }

    updateChatListDetails(details){
        let formater = new DateTimeFormater(details.created_at);
        var formattedTime = formater.message_time()
        
        var chat = document.getElementById(`${this.id}`);

        chat.querySelector('.message-text').innerHTML = details.message;
        chat.querySelector('.message-time').innerHTML = formattedTime;
        if(details.senderId != user.id){
            chat.querySelector('.message-count').innerHTML = details.unread_message_count.length;
        }
    }

    removeMessageToChat(){

    }

    createNewChat(){
        
    }

    debounceGetTempChatId(delay = 300) {
        // Очищаем предыдущий таймер
        clearTimeout(this.timeoutId);

        // Устанавливаем новый таймер
        return new Promise((resolve) => {
            // Устанавливаем новый таймер
            this.timeoutId = setTimeout(async () => {
                const result = await this.getNewTempChatId();
                resolve(result);  // Возвращаем результат через resolve
            }, delay);
        });
    }

    async getNewTempChatId(){
        try {
            

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const result = await response.json();
            return result;
        } catch (error) {
            console.error('Error setting user offline:', error);
        }
    }

    static getNewTempChat(user_id){
        fetch(`https://swiftlylink.ru/api/get_new_chat_id`, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json',
            },
        }).then(result => result.json()).then(request => {

            var newChatDiv = document.createElement('div');
            newChatDiv.classList.add('chat_container');

            var topbar = document.createElement('div');
            topbar.classList.add('topbar');

            var messages = document.createElement('div');
            messages.classList.add('messages');

            var bottombar = document.createElement('div');
            bottombar.classList.add('bottombar');

            this.getTopBarChat(topbar, user_id);
            this.getMessagesBarChat(messages, request.new_chat_id);
            this.getBottomBarChat(bottombar);

            newChatDiv.appendChild(topbar);
            newChatDiv.appendChild(messages);
            newChatDiv.appendChild(bottombar);

            var noSelectedChat = document.querySelector('.chat-no-selected');
            
            if(!noSelectedChat){
                var selectedChat = document.querySelector('.chat_container');
                selectedChat.remove();
            }
            else{
                noSelectedChat.remove();
            }

           newChat = {
                chat_id: request.new_chat_id,
                user_id: user_id
            }
            document.querySelector('.main-container').appendChild(newChatDiv);

            setTimeout(function(){
                initChatInputs(true);
            }, 300);
        });

    }

    static getTopBarChat(topbar, user_id){
        fetch(`https://swiftlylink.ru/chat_top_bar/${user_id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
        })
        .then(result => result.text())
        .then(data => {topbar.innerHTML = data});
    }

    static getMessagesBarChat(messages, chat_id){
        fetch(`https://swiftlylink.ru/chat_messages_bar/${chat_id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
        })
        .then(result => result.text())
        .then(data => {messages.innerHTML = data});
    }

    static getBottomBarChat(bottombar){
        fetch(`https://swiftlylink.ru/chat_bottom_bar`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
        })
        .then(result => result.text())
        .then(data => {bottombar.innerHTML = data});
    }
}