import { Message } from "../chat/Messages.js";

export class MessageContextMenu {
    constructor(chatId) {
        this.selectedMode = false;
        this.selected_ids = [];
        this.chatId = chatId;
    }

init(){
    document.addEventListener('DOMContentLoaded', () => {
        if(!document.getElementById('unselected_all_message')) return;
        // Получаем все элементы с классом target
        const targets = document.querySelectorAll('.target');

        const cancel_btn = document.getElementById('unselected_all_message');
    
        cancel_btn.addEventListener('click', () =>{
            const chatTopbar = document.querySelector('.chat_topbar');
            this.selected_ids.forEach(id => {
                document.getElementById(id).classList.remove("selected");
            });
            this.selected_ids = [];
            chatTopbar.classList.remove('show_buttons');
            this.selectedMode = false;
        });
    
    
        // Для каждого элемента добавляем обработчик события
        targets.forEach(target => {
            this.initContextMenu(target);
        });
    
        // Закрытие контекстного меню при клике в любом другом месте
        document.addEventListener('click', (e) => {
            const menu = document.querySelector('.context_menu');
            if (menu && !menu.contains(e.target) && !e.target.classList.contains('target')) {
                menu.classList.remove('show');
                setTimeout(() => menu.remove(), 300); // Ждём завершения анимации перед удалением
            }
        });

        
    
    });
}

initDeleteBtn(){
    if(!document.querySelector('#chat-topbar-delete-selected-messages')) return;
    var this_context = this;
    document.querySelector('#chat-topbar-delete-selected-messages').addEventListener('click', function(e){
        Message.deleteMessagesAtId(this_context.chatId, user.id, this_context.selected_ids).then((e) =>{
            this_context.selectedMode = false;
            this_context.selected_ids = [];
        });
    })
}


initContextMenu(target){
    target.addEventListener('contextmenu', (e) => {
        e.preventDefault(); // Предотвращаем стандартное контекстное меню
        const chatTopbar = document.querySelector('.chat_topbar');
        var id = target.id;
        // Удаляем уже существующее контекстное меню, если оно есть
        const existingMenu = document.querySelector('.context_menu');
        if (existingMenu) {
            existingMenu.classList.remove('show');
            setTimeout(() => existingMenu.remove(), 300); // Ждём завершения анимации перед удалением
        }

        // Загружаем и отображаем контекстное меню
        fetch('https://swiftlylink.ru/message_context_menu')
            .then(response => response.text())
            .then(html => {
                // Создаём новый элемент контекстного меню
                const menu = document.createElement('div');
                menu.className = 'context_menu';
                menu.innerHTML = html;
                document.body.appendChild(menu);

                // Устанавливаем позицию меню
                const { clientX: mouseX, clientY: mouseY } = e;

                const menuHeight = menu.offsetHeight;

                if (mouseY + menuHeight > window.innerHeight) {
                    menu.style.top = `${mouseY - menuHeight}px`; 
                } else {
                    menu.style.top = `${mouseY}px`;
                }

                menu.style.left = `${mouseX}px`;

                // Показываем меню с анимацией
                setTimeout(() => menu.classList.add('show'), 10); // Небольшая задержка для корректного применения стилей

                // Добавляем обработчик клика на элементы li
                const menuItems = menu.querySelectorAll('li');
                menuItems.forEach(item => {
                    item.addEventListener('click', () => {
                        if(item.id == "selection"){
                            if(document.getElementById(id).classList.contains("selected")) {
                                this.selected_ids = this.selected_ids.filter(item => item !== id);
                                document.getElementById(id).classList.remove("selected");
                            }
                            else{
                                this.selected_ids.push(id);
                                document.getElementById(id).classList.add("selected");
                            }

                            if(this.selected_ids.length > 0){
                                chatTopbar.classList.add('show_buttons');
                                this.selectedMode = true;
                            }
                            else{
                                chatTopbar.classList.remove('show_buttons');
                                this.selectedMode = false;
                            }
                        }  

                        if(item.id == "delete"){
                            if(this.selected_ids.length <= 0){
                                Message.deleteMessageAtId(this.chatId, user.id, id).then((e) =>{
                                    this.selectedMode = false;
                                    this.selected_ids = [];
                                });;
                            }
                            else{
                                Message.deleteMessagesAtId(this.chatId, user.id, this.selected_ids).then((e) =>{
                                    this.selectedMode = false;
                                    this.selected_ids = [];
                                });
                            }
                            
                        }
                        // Удаляем меню после клика по li
                        menu.classList.remove('show');
                        setTimeout(() => menu.remove(), 300);                           
                    });
                });
            })
            .catch(error => console.error('Ошибка при загрузке контекстного меню:', error));

        return false;
    });

    target.addEventListener('click', (e) =>{
        if(this.selectedMode){
            const chatTopbar = document.querySelector('.chat_topbar');
            if(document.getElementById(e.currentTarget.id).classList.contains("selected")) {
                this.selected_ids = this.selected_ids.filter(item => item !== e.currentTarget.id);
                document.getElementById(e.currentTarget.id).classList.remove("selected");
            }
            else{
                this.selected_ids.push(e.currentTarget.id);
                document.getElementById(e.currentTarget.id).classList.add("selected");
            }

            if(this.selected_ids.length <= 0){
                chatTopbar.classList.remove('show_buttons');
                this.selectedMode = false;
            }
            else{
                chatTopbar.classList.add('show_buttons');
               
            }
        }
        
    });
}

}