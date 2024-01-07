<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
</head>

<body style="padding: 0px">
    <div class="login">
        <div class="container" style=" padding-top: 5%; padding-bottom: 5%;">
            <div class="logo">
                <img src="images/logo-IRNITU.png" alt="logo-IRNITU" />
            </div>
            <h1>
                ИРКУТСКИЙ НАЦИОНАЛЬНЫЙ<br />
                ИССЛЕДОВАТЕЛЬСКИЙ<br />
                ТЕХНИЧЕСКИЙ УНИВЕРСИТЕТ
            </h1>
        </div>

        <form class="container"
            style="background-color: #ffffff; flex-direction: column; width: 25%; height: 50%; border: 1px solid #D9D9D9; border-radius: 25px; min-width: 400px; min-height: 400px">
            <h1 style="color: #000000; margin-bottom: 5%">
                Авторизация
            </h1>
            <div style="margin-bottom: 5%; width: 85%;">
                <input class="login-input" type="text" placeholder="Логин / E-mail" name="login" id="login">
            </div>

            <div style="margin-bottom: 5%; width: 85%;">
                <input class="login-input" type="password" placeholder="Пароль" name="password" id="password">
            </div>

            <div class="container" style="align-items: center; margin-bottom: 5%">
                <input type="checkbox" style="margin-right: 10px;" name="remember" id="remember">
                <label for="remember">Запомнить меня на этом компьютере</label>
            </div>

            <button style="margin-bottom: 5%" type="submit">Войти</button>

            <button type="submit">Войти с помощью Кампуса</button>
        </form>
    </div>
</body>

</html>
