function loadAndOpenModal(path){
    fetch(path)
            .then(response => response.text())
            .then(html => {
                const modal = document.createElement('div');
                var link = document.createElement('link');
                link.rel = "stylesheet";
                link.href = "https://swiftlylink.ru/css/modals/modal.css";
                link.id = "modal-style";

                if(!document.getElementById('modal-style')) modal.appendChild(link);
                var id = document.querySelectorAll('[id^="modal-"]').length;
                modal.style.position = 'absolute';
                
                modal.innerHTML += html;

                document.body.appendChild(modal);
                const modalElement = document.getElementById('new-modal');
                modalElement.id = `modal-${id}`;
                modalElement.style.display = 'block';

                setTimeout(() => modalElement.classList.add('show'), 1);

            // Обработчик клика на модальное окно
            modalElement.addEventListener('click', function(e) {
                if (e.target === modalElement) {
                    closeModal(id); // Закрываем модальное окно по его ID
                }
            });
                
                
            })
            .catch(error => console.error('Error fetching modal template:', error));
}

window.closeModal = function(param) {
    var modal = null;
    if(!isNaN(param)){
        modal = document.getElementById(`modal-${param}`);
    }
    else{
        var parent = param;
        while (parent && !parent.id.startsWith('modal')) {
            parent = parent.parentElement;
        }
        modal = parent;
    }

    if (modal) {
        modal.classList.remove('show');
        setTimeout(() => {
            modal.parentElement.remove();
        }, 300); // Delay to match the animation duration
    }
};