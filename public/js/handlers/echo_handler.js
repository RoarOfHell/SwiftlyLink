import { EchoType } from '../enums/EchoEnum.js';
import { EventEmitter } from '../events/EventEmitter.js';
import { Message } from '../chat/Messages.js';
import { Chat } from '../chat/Chats.js';
import { TypingIndicator } from '../chat/TypingIndicator.js';

export class EchoHandler {
    constructor(enum_type, ids, context_menu_object) {
        this.enum_type = enum_type;
        this.ids = ids;
        this.eventEmitter = new EventEmitter();
        this.typingIndicator = null;
        this.context_menu_object = context_menu_object;
    }

    async init() {
        try {
            switch (this.enum_type) {
                case EchoType.AtChatId:
                    
                    if(!this.ids || typeof(this.ids) != 'object' || this.ids.length <= 0) return;
                   
                    this.ids.forEach(id => {
                        this.#initChatEcho(id.chat_id);
                        this.typingIndicator = new TypingIndicator(id.chat_id, user.id);
                        this.typingIndicator.listenForTypingEvents();
                    });
                    
                    break;
    
                case EchoType.AtUserId:
                    
                    break;
            
                default:
                    
                    break;
            }
        } catch (error) {
            console.log(error);
        }
        
    }

    async #initChatEcho(chat_id){
        Echo.private(`chat.${chat_id}`)
        .listen('MessageSent', (e) => {
            let url = window.location.href; 
            var selected_chatId = url.substring(url.lastIndexOf('/') + 1);
            var chat = new Chat(chat_id, '1', '2020.10.10', '2020.10.10');
            if(chat_id == selected_chatId){
                var message = new Message(e.message_id, e.message, e.senderId, e.chatId, e.created_at);
                
                chat.addMessageToChat(message, this.context_menu_object, e.avatar_path);
            }
            else{
                notificationMessage(e.senderId, e.message, e.avatar_path);
            }
            chat.updateChatListDetails(e);
           // updateChatInfo(chatId, e.message, e.created_at);

            this.eventEmitter.emit('MessageSent', message);
        })
        .listen('MessageDeleted', (e) => {
            e.message_id.forEach(id => {
                if(document.getElementById(`${id}`)){
                    document.getElementById(`${id}`).parentElement.remove();
                }
            });
            var chat = new Chat(chat_id, '1', '2020.10.10', '2020.10.10');
            chat.updateChatListDetails(e);
        })
        .error((error) => {
            console.error('Ошибка при подписке на канал:', error);
            console.log('Ответ на авторизацию:', error.error);
        });
    }

    #initUserEcho(){
        
    }



    onMessageSent(listener){
        this.eventEmitter.on('MessageSent', listener);
    }

    onMessageEdit(){
        this.eventEmitter.on('MessageEdit', listener);
    }

    onMessageDeleted(){
        this.eventEmitter.on('MessageDeleted', listener);
    }
}