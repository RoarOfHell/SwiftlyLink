function openCrop(){
    loadAndOpenModal('https://swiftlylink.ru/modal_crop');

    const script = document.createElement('script');
    script.src = "js/crop/crop_image.js";
    document.body.appendChild(script);
}

function openLanguage(){
    loadAndOpenModal('https://swiftlylink.ru/modal_language');

    setTimeout(function(){
        document.querySelectorAll('input[name="language"]').forEach(function(e){
            if(e.value == locale){
                e.checked = true;
            }
        });
    }, 200);
}

function openUsernameSettings(){
    loadAndOpenModal('https://swiftlylink.ru/modal_username_settings');
}

function openTagSettings(){
    loadAndOpenModal('https://swiftlylink.ru/modal_tag_settings');
}

function openBirthdaySettings(){
    loadAndOpenModal('https://swiftlylink.ru/modal_birthday_settings');
}

function openFisrtNameSettings(){
    loadAndOpenModal('https://swiftlylink.ru/modal_first_name_settings');
}

function openLastNameSettings(){
    loadAndOpenModal('https://swiftlylink.ru/modal_last_name_settings');
}



function saveNickname(value){
    var nickname = document.getElementsByName('nickname')[0].value;
    var elements = document.getElementsByName('modal_nickname');

    elements.forEach(element => {
        element.innerText = nickname;
    });

    fetch(`https://swiftlylink.ru/update_user_nickname/${nickname}`, {
        method: 'GET',
        headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json',
        },
    }).then(data => data).then(info => {
        if(info){
            //location.reload();
            closeModal(value);
        }
    })
    .catch(error => console.error(error));
}

function saveTag(value){
    var tag = document.getElementsByName('tag')[0].value.replace(/@/g, "");
    var tags = document.getElementsByName('modal_tag');

    tags.forEach(tagElem => {
        tagElem.innerText = '@' + tag;
    });

    fetch(`https://swiftlylink.ru/update_user_tag/${tag}`, {
        method: 'GET',
        headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json',
        },
    }).then(data => data).then(info => {
        if(info){
            //location.reload();
            closeModal(value);
        }
    })
    .catch(error => console.error(error));
}