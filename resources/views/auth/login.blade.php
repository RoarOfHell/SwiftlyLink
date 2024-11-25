<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <link rel="stylesheet" href="css/auth/auth.css">
</head>
<body>
    <form action="{{ route('post_signin') }}" method="post">
        {!! csrf_field() !!}
        <div class="login-container">
            <div class="login-box">
                <div class="circle"></div> <!-- Добавим декоративный элемент -->
                <h2>{{ __('auth.authorization') }}</h2>
                
                    <div class="input-group">
                        <input type="text" name="email" id="email" required>
                        <label>{{ __('auth.email') }}</label>
                    </div>
                    <div class="input-group">
                        <input type="password" name="password" id="password" required>
                        <label>{{ __('auth.password') }}</label>
                    </div>
                   
                    <button type="submit" class="btn">{{ __('auth.login') }}</button>
                    <p class="register-link">{{ __('auth.not_account') }} <a href="{{ route('reg') }}">{{ __('auth.register') }}</a></p>
                    @isset($error)
                    <div class="error">{{$error}}</div>
                @endisset
                
            </div>
        </div>
    </form>
</body>
</html>