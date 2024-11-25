import { DateTimeFormater } from "../date_time/DateTimeFormater.js";
import { User } from "../user/Users.js";

export class Message {
    constructor(message_id, message, sender_id, chat_id, created_at) {
        this.id = message_id;
        this.message = message;
        this.sender_id = sender_id;
        this.chat_id = chat_id;
        this.created_at = created_at;
    }

    get id(){ return this._id; }

    set id(value){ 
        if(!value && value.trim() == '') return;
        this._id = value;
        return;
    }

    get message(){ return this._message; }

    set message(value){
        if(!value && value.trim() == '') return;
        this._message = value;
        return;
    }

    get sender_id(){
        return this._sender_id;
    }

    set sender_id(value){
        if(!value && value.trim() == '') return;
        this._sender_id = value;
        return;
    }

    get chat_id(){
        return this._chat_id;
    }

    set chat_id(value){
        if(!value && value.trim() == '') return;
        this._chat_id = value;
        return;
    }

    get created_at(){
        return this._created_at;
    }

    set created_at(value){
        if(!value && value.trim() == '') return;;
        this._created_at = value;
        return;
    }

    async get_html(context_menu_object, avatar_path){
        var user = await (new User()).get_session_user();

        let formater = new DateTimeFormater(this._created_at);
        var formattedTime = formater.message_time()

        const messageDiv = document.createElement('div');
        messageDiv.className = 'user_message';
        console.log(`get_html: ${avatar_path}}`);
        const userIconDiv = document.createElement('div');
        userIconDiv.className = 'user_icon';
        userIconDiv.innerHTML = `
        <div class="icon">
        ${(avatar_path == null ? `<span class="icon" class="material-symbols-outlined">
            person
            </span>` : `<img class="icon" src="${avatar_path}" alt="">`)}
        </div>
        `;

        const messageContentDiv = document.createElement('div');
        messageContentDiv.className = `user_message_content ${this._sender_id == user.id ? '' : 'other'} target`;
        messageContentDiv.id = this._id;

        context_menu_object.initContextMenu(messageContentDiv);

        messageContentDiv.innerHTML = `
            <span class="message">${this.message}</span>
            <span class="send_time">${formattedTime}</span>
        `;

        messageDiv.appendChild(userIconDiv);
        messageDiv.appendChild(messageContentDiv);

        
        return messageDiv;
    }

    static async deleteMessageAtId(chatId1, user_id, message_id){
        var new_selected_ids = [];
    
        new_selected_ids.push(message_id);
        this.deleteMessagesAtId(chatId1, user_id, new_selected_ids).then((e) =>{
            return e;
        });
    }

    static async deleteMessagesAtId(chat_id, user_id, message_ids){

        var dataToSend = {
            'chat_id': chat_id,
            'user_id': user_id,
            'message_ids': message_ids
        };
    
        fetch("/chat/remove_messages", { 
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(dataToSend)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Ошибка сети');
            }
            return response.json(); // Преобразуем ответ в JSON
        })
        .then(data => {
            if(data.message == 'complited'){
                const chatTopbar = document.querySelector('.chat_topbar');
                chatTopbar.classList.remove('show_buttons');
                return 'seccess';
            }
        })
        .catch(error => {
            console.error('Ошибка:', error); 
            return 'error';
        });
    }
}