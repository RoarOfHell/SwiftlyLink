document.addEventListener('DOMContentLoaded', () => {
    var search_btn = document.getElementById('search_btn');

    search_btn.addEventListener('click', function(){
        var search_box = document.getElementById('search_box');

        search_box.classList.toggle('show');
    });
});