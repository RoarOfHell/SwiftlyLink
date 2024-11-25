function initChatInputs(is_new_chat = false){
    console.log(newChat);
    if(document.getElementById('send_message')){
        document.getElementById('send_message').addEventListener('click', function(){
            var message = document.getElementById('input_message').value;
            if(message.trim() == '') return;
            send_message(message, is_new_chat);
            document.getElementById('input_message').value = '';
            
        });
    }
    
    
    if(document.getElementById('input_message')){
        document.getElementById('input_message').addEventListener('keyup', function(e){
        
            if (e.key === 'Enter' || e.keyCode === 13) {
                var message = document.getElementById('input_message').value;
                if(message.trim() == '') return;
                send_message(message, is_new_chat);
                document.getElementById('input_message').value = '';
            }
        });
    }
}


function send_message(message, is_new_chat){
    let url = window.location.href; 
    let chat_id = url.substring(url.lastIndexOf('/') + 1);
    const dataToSend = {
        message: message,
        chat_id: chat_id,
        avatar_path: self_avatar_path,
        is_new_chat: is_new_chat,
        new_chat_user_id: newChat?.user_id ?? null,
        new_chat_id: newChat?.chat_id ?? null
    };

    fetch("/chat/send_message", {  
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
        return response.json();
    })
    .then(data => {
        
    })
    .catch(error => {
        console.error('Ошибка:', error);
    });

}