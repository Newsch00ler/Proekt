<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
</head>
<header>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid" style="display: flex;">
            <a class="navbar-brand container" href="#">
                <div class="logo">
                    <img src="images/logo-IRNITU.png" alt="logo-IRNITU" />
                </div>
                <h1>Личный кабинет</h1>
            </a>
            <div class="collapse navbar-collapse" style="justify-content: end;">
                <ul class="navbar-nav" style="align-items: center;">
                    @yield('navbar_ul_content')
                </ul>
                <button type="button">Выход</button>
            </div>
        </div>
    </nav>
</header>

<body>
    {{-- <div id="zatemnenie">
        <div id="okno">
            Всплывающее окошко!<br>
            <a href="#" class="close">Закрыть окно</a>
        </div>
    </div> --}}
    @yield('main_content')
</body>

</html>
