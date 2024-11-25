<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="yandex-verification" content="8e8251633ac0b015" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Swiftlylink — современный мессенджер с удобным интерфейсом и возможностью просмотра аниме и видео.">
    <link rel="shortcut icon" href="/favicon/favicon.ico" type="image/x-icon">
    <title>Swiftlylink</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/pages/home.css">
</head>
<body>

<header>
    <div class="logo">Swiftlylink</div>
    <nav>
        <ul>
            <li><a href="#">Главная</a></li>
            <li><a href="https://swiftlylink.ru/chat">Чат</a></li>
            <li><a href="https://swiftlylink.ru/anime">Аниме</a></li>
            <li><a href="#about">О нас</a></li>
        </ul>
    </nav>
</header>

<div class="hero">
    <h1>Swiftlylink — Мессенджер будущего</h1>
    <p>Чат, видео-чат и аниме в одном приложении! Подключайтесь к лучшему сервису для общения и просмотра.</p>
    <div class="btn-container">
        <a href="https://swiftlylink.ru/chat">Перейти в чат</a>
        @if(!$isAuth)
        <a href="https://swiftlylink.ru/reg">Регистрация</a>
        @endif
    </div>
</div>

<section class="features">
    <h2>Наши возможности</h2>
    <div class="features-grid">
        <div class="feature">
            <img src="https://img.icons8.com/ios-filled/50/ffffff/online-chat.png" alt="Чат">
            <h3>Swiftlylink Chat</h3>
            <p>Находится в стадии разработки</p>
        </div>
        <div class="feature">
            <img src="" alt="">
            <h3>Swiftlylink Voice</h3>
            <p>Находится в стадии разработки</p>
        </div>
        <div class="feature">
            <img src="https://img.icons8.com/ios-filled/50/ffffff/anime.png" alt="Аниме">
            <h3>Swiftlylink Anime</h3>
            <p>Находится в стадии разработки</p>
        </div>
    </div>
</section>

<section class="testimonials">
    <h2>Отзывы пользователей</h2>
    <div class="testimonial-cards">
        <div class="testimonial">
            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="User 1">
            <p>Тестовый отзыв 1</p>
        </div>
        <div class="testimonial">
            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="User 2">
            <p>Тестовый отзыв 2</p>
        </div>
        <div class="testimonial">
            <img src="https://randomuser.me/api/portraits/men/45.jpg" alt="User 3">
            <p>Тестовый отзыв 3</p>
        </div>
    </div>
</section>

<section class="faq">
    <h2>Часто задаваемые вопросы</h2>
    <div class="faq-item">
        <h4>Как зарегистрироваться в Swiftlylink?</h4>
        <p>Просто перейдите на страницу регистрации, заполните данные и начните пользоваться мессенджером.</p>
    </div>
    <div class="faq-item">
        <h4>Есть ли подписка на премиум-функции?</h4>
        <p>На данный момент все функции бесплатны. Премиум-подписка появится в будущем с расширенными возможностями.</p>
    </div>
</section>

<footer>
    &copy; 2024 Swiftlylink. Все права защищены.
</footer>

<script>
    // Анимация для FAQ секции
    document.querySelectorAll('.faq-item').forEach(item => {
        item.addEventListener('click', () => {
            const content = item.querySelector('p');
            content.style.display = content.style.display === 'block' ? 'none' : 'block';
        });
    });

    alert("Данный проект находится в стадии разработки!");
</script>
</body>
</html>