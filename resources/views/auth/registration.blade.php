<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('auth.registration') }}</title>
    <link rel="stylesheet" href="css/auth/auth.css">
</head>
<body>
    
        <div class="login-container">
            <div class="login-box">
                <div class="circle"></div> <!-- Добавим декоративный элемент -->
                <h2>{{ __('auth.registration') }}</h2>
                @isset($error)
                    <div class="error">{{$error}}</div>
                @endisset
                
                <form action="{{ route('registration_submit') }}" method="post">
        {!! csrf_field() !!}
                    <div class="input-group" >
                        <input type="email" id="email" name="email" required>
                        <label>{{ __('auth.email') }}</label>
                    </div>
                    <div class="input-group" >
                        <input type="text" id="username" name="username" required>
                        <label>{{ __('auth.nickname') }}</label>
                    </div>
                    <div class="input-group" >
                        <input type="password" id="password" name="password" required>
                        <label>{{ __('auth.password') }}</label>
                    </div>
                    <div class="input-group">
                        <input type="password" id="repeat_password" name="repeat_password" required>
                        <label>{{ __('auth.repeatpwd') }}</label>
                    </div>
                    <button type="submit" class="btn">{{ __('auth.register') }}</button>
                    <p class="register-link">{{ __('auth.have_account') }} <a href="{{ route('login') }}">{{ __('auth.login') }}</a></p>
                    
                    </form>
            </div>
        </div>
    
</body>
</html>