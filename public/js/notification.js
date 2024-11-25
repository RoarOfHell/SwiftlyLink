function notificationMessage(sender_id, message, avatar_path){
    var notifications = document.querySelector('.notifications');

    var newNotific =
    `
    <div class="notification">
        <div class="notification_icon">
        ${(avatar_path == null ? `<span class="material-symbols-outlined">
            person
            </span>` : `<img src="${avatar_path}" alt="">`)}
        </div>

        <div class="notification_details">
            <div class="notification_title">
                <span>${sender_id}</span>
            </div>

            <div class="notification_message">
                <span>${message}</span>
            </div>
        </div>

        <div class="btn_close_notification">
            <span>close</span>
        </div>
    </div>
    `;

    notifications.innerHTML += newNotific;


    var allNotif = document.querySelectorAll('.btn_close_notification');

    allNotif.forEach(element => {
        element.addEventListener('click', (e)=>{
            e.target.parentElement.parentElement.remove();
        });
    });
}