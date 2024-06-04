<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
</head>

<body style="padding: 0px">
    <div class="login">
        <div class="container" style=" padding-top: 5%; padding-bottom: 5%;">
            <div class="logo">
                <img src="{{ asset('assets/css/logo-IRNITU.png') }}" alt="logo-IRNITU" />
            </div>
            <h1>
                ИРКУТСКИЙ НАЦИОНАЛЬНЫЙ<br />
                ИССЛЕДОВАТЕЛЬСКИЙ<br />
                ТЕХНИЧЕСКИЙ УНИВЕРСИТЕТ
            </h1>
        </div>

        <div class="form-wrapper">
            <div class="form-container">
                <form id="loginForm" method="post" action="{{ url('/login') }}"
                    style="display: flex; flex-direction: column; align-items: center; width: 100%;">
                    @csrf
                    <h1 style="color: #000000; margin-bottom: 5%; text-align: center;" id="errorMessage"
                        data-error="{{ session('error') }}">
                        Авторизация
                    </h1>
                    <input class="login-input" type="text" placeholder="Логин" name="login" id="login">
                    <input class="login-input" type="password" placeholder="Пароль" name="password" id="password">
                    <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: center; margin-bottom: 5%;">
                        <input type="checkbox" style="margin-right: 10px;" name="remember" id="remember">
                        <label for="remember" style="color: black; margin: 0%; text-align: center;">Запомнить меня на
                            этом компьютере</label>
                    </div>
                    <button type="submit" id="login_button"
                        style="margin-bottom: 5%;">Войти</button>
                </form>
                <form id="campusLoginForm" method="post" action="{{ url('/campusAuth') }}"
                    style="display: flex; flex-direction: column; align-items: center; width: 100%;">
                    @csrf
                    <button type="submit">Войти с помощью Кампуса</button>
                </form>
            </div>
        </div>

        <div class="modal fade" id="myModalLogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center" id="exampleModalLongTitle">Сообщение</h5>
                    </div>
                    <div class="modal-body" id="modalMessage">
                        {{ $message }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>

        @if (session()->has('error'))
            <div class="modal fade" id="myModalLoginError" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-center" id="exampleModalLongTitle">Сообщение</h5>
                        </div>
                        <div class="modal-body" id="modalMessage">
                            {{ session('error') }}
                        </div>
                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal">Закрыть</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
</body>

</html>
