export class TypingIndicator {
    constructor(chatId, userId, typingDelay = 1000) {
        this.chatId = chatId;
        this.userId = userId;
        this.typingDelay = typingDelay;
        this.typingTimeout = null;
        this.isTyping = false;
        this.lastMessage = "";
        // Установите обработчик событий для поля ввода
        this.setupInputHandler();
    }

    setupInputHandler() {
        const inputElement = document.getElementById('input_message');
        if(inputElement){
            inputElement.addEventListener('input', () => this.handleInput());
        }
        
    }

    handleInput() {
        if (!this.isTyping) {
            this.sendTypingStatus(true); // Отправляем статус "печатает"
            this.isTyping = true;
        }

        // Сбрасываем таймер
        clearTimeout(this.typingTimeout);
        this.typingTimeout = setTimeout(() => {
            this.sendTypingStatus(false); // Отправляем статус "не печатает"
            this.isTyping = false;
        }, this.typingDelay);
    }

    sendTypingStatus(isTyping) {
        fetch(`https://swiftlylink.ru/api/user-typing?chat_id=${this.chatId}&user_id=${this.userId}&is_typing=${isTyping}`, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json',
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    listenForTypingEvents() {
        window.Echo.private(`chat.${this.chatId}`)
            .listen('UserTyping', (e) => {
                this.updateTypingIndicator(e.userId, e.isTyping);
            });
    }

    updateTypingIndicator(userId, isTyping) {
        const inChat = document.querySelector('.topbar_last_online_time');
        const inChatList = document.querySelector('.message-text');
        if(userId != user.id){
            if (isTyping == 'true') {
                this.lastMessage = inChatList.innerHTML;
                if(inChat) inChat.innerText = `печатает...`;
                inChatList.innerText = `печатает...`;
            } else {
                if(inChat)  inChat.innerText = 'В сети';
                inChatList.innerHTML = this.lastMessage;
            }
        }
    }
}