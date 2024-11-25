import { EchoType } from '../enums/EchoEnum.js';
import { EchoHandler } from '../handlers/echo_handler.js';
import { User } from '../user/Users.js';
import { Chat } from './Chats.js';
import { Search } from './Search.js';
import { MessageContextMenu } from "../context_menu/MessageContextMenu.js";

let url = window.location.href; 
var selected_chatId = url.substring(url.lastIndexOf('/') + 1);



var message_context_menu = new MessageContextMenu(selected_chatId);
message_context_menu.init();
message_context_menu.initDeleteBtn();

var echo_chat_handler = new EchoHandler(EchoType.AtChatId, ids, message_context_menu);

echo_chat_handler.init();

echo_chat_handler.onMessageSent((e) =>{
    
});

User.setOnline();

var search_class = new Search();



document.querySelectorAll('.menu-tools-content').forEach(function(elem){
    elem.addEventListener('click', function(){
        document.getElementById('menu').classList.remove('show');
    });
});

document.querySelector('#sidebar_search').addEventListener('input', function(e){
    var search_text = e.target.value;
    search_class.showSearchUsers(search_text);
});

document.querySelectorAll('.message-card').forEach(card => {
    card.addEventListener('click', function() {
        const chatId = this.id; // Получаем ID чата из атрибута id блока
        window.location.href = `/chat/${chatId}`; // Перенаправляем на URL с id чата
    });
});

document.getElementById('menu_btn').addEventListener('click', function(){
    document.getElementById('menu').classList.add('show');
});

document.getElementById('menu').addEventListener('click', function(e){
    if(e.target.id == "menu"){
        e.target.classList.remove('show');
    }
});

document.getElementById('go_to_anime').addEventListener('click', function(){
    window.location.href = '/anime';
});


document.addEventListener("DOMContentLoaded", function() {
    const messagesContainer = document.querySelector('.messages');
    if (messagesContainer) {    
        // Прокручиваем вниз при первой загрузке
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
});




window.addEventListener('beforeunload', function (event) {
    User.setOffline();
});
