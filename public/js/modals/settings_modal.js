document.addEventListener('DOMContentLoaded', () => {
    const openModalButton = document.getElementById('settings_btn');

    openModalButton.addEventListener('click', () => {
        loadAndOpenModal('https://swiftlylink.ru/modal_settings');

        setTimeout(function(){
            var main_title = document.querySelector('.modal-title').innerHTML;

            document.getElementById('back').addEventListener('click', function(){
                document.querySelectorAll('.page').forEach(function(elem){
                    elem.classList.add('hide');
                });
                document.getElementById('main-page').classList.remove('hide');
                document.querySelector('.modal-title').innerHTML = main_title;
                document.getElementById('back').classList.remove('show');
            });

            document.getElementById('my-account')?.addEventListener('click', function(e){
                document.getElementById('my-account-page').classList.remove('hide');
                document.getElementById('main-page').classList.add('hide');

                var selected = this.querySelector('.category-name').innerHTML;
                document.querySelector('.modal-title').innerHTML = selected;
                document.getElementById('back').classList.add('show');
            });

            document.getElementById('notification-and-sounds')?.addEventListener('click', function(){
                document.getElementById('notification-and-sounds-page').classList.remove('hide');
                document.getElementById('main-page').classList.add('hide');

                var selected = this.querySelector('.category-name').innerHTML;
                document.querySelector('.modal-title').innerHTML = selected;
                document.getElementById('back').classList.add('show');
            });

            document.getElementById('confidentiality')?.addEventListener('click', function(){
                document.getElementById('confidentiality-page').classList.remove('hide');
                document.getElementById('main-page').classList.add('hide');

                var selected = this.querySelector('.category-name').innerHTML;
                document.querySelector('.modal-title').innerHTML = selected;
                document.getElementById('back').classList.add('show');
            });

            document.getElementById('chat-settings')?.addEventListener('click', function(){
                document.getElementById('chat-settings-page').classList.remove('hide');
                document.getElementById('main-page').classList.add('hide');

                var selected = this.querySelector('.category-name').innerHTML;
                document.querySelector('.modal-title').innerHTML = selected;
                document.getElementById('back').classList.add('show');
            });

            document.getElementById('chat-folders')?.addEventListener('click', function(){
                document.getElementById('chat-folders-page').classList.remove('hide');
                document.getElementById('main-page').classList.add('hide');

                var selected = this.querySelector('.category-name').innerHTML;
                document.querySelector('.modal-title').innerHTML = selected;
                document.getElementById('back').classList.add('show');
            });
        }, 500);
    });

    // Function to switch between tabs
    window.openTab = function(tabId) {
        const tabcontent = document.querySelectorAll('.tab-content');
        tabcontent.forEach(tab => tab.style.display = 'none');

        const tabbuttons = document.querySelectorAll('.tab-button');
        tabbuttons.forEach(btn => btn.classList.remove('active'));

        document.getElementById(tabId).style.display = 'block';
        document.querySelector(`.tab-button[onclick="openTab('${tabId}')"]`).classList.add('active');
    };

    // Function to handle logout
    window.logout = function() {
        event.preventDefault(); 
        document.getElementById('logout-form').submit();
    };

    window.switchLanguage = function(elem){
        var language = elem.querySelector('input[name="language"]');

        fetch(`https://swiftlylink.ru/switch_language/${language.value}`, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json',
            },
        }).then(data => data).then(info => {
            if(info){
                location.reload();
            }
        })
        .catch(error => console.error(error));
    };    
});