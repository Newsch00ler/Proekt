<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Администратор - {{ $title }}</title>
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
<header class="admin">
    <nav class="navbar navbar-expand-lg">
        <div id="errorMessage1" data-error="{{ session('error') }}" class="container-fluid"
            style="justify-content: space-around">
            <a class="navbar-brand container" href="{{ url('/admin/dashboard') }} ">
                <h1>Администратор</h1>
            </a>
            <div class="collapse navbar-collapse" style="justify-content: end;">
                <ul class="navbar-nav" style="align-items: center;">
                    <li class="nav-item">
                        <select onchange="location = this.value; resetOptions(this);">
                            <option disabled selected>Управление</option>
                            <option value="/admin/users">Пользователи</option>
                            <option value="/admin/works">Работы</option>
                            <option value="/admin/protocols">Протоколы</option>
                            <option value="/admin/check-works">Оценки работ</option>
                            <option value="/admin/subject-areas">Предметные области</option>
                        </select>
                    </li>
                </ul>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit">Выход</button>
                </form>
            </div>
        </div>
    </nav>
</header>

<body class="admin">
    @if (session()->has('error'))
        <div class="modal fade" id="myModalLoginError1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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
    <div class="modal fade" id="waitModalAdmin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="exampleModalLongTitle">Ожидайте загрузку</h5>
                </div>
                <div class="modal-body" id="waitModalMessage">
                    <div class="loading-indicator">
                        Выполняется выгрузка файлов
                    </div>
                </div>
            </div>
        </div>
    </div>
    @yield('admin_main_content')
</body>

</html>
