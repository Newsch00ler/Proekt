<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $viewRole }} - {{ $title }}</title>
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
</head>
<header>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid" style="justify-content: space-around">
            <a class="navbar-brand container" href="{{ $url }} ">
                <div class="logo">
                    <img src="images/logo-IRNITU.png" alt="logo-IRNITU" />
                </div>
                <div id="errorMessage1" data-error="{{ session('error') }}">
                    <h1>Личный кабинет</h1>
                    <hr style="margin: 2px 0 2px 0; border: 1px solid white; background: white">
                    <h3>{{ $full_name }}</h3>
                    <h3>{{ $viewRole }}</h3>
                </div>
            </a>
            <div class="collapse navbar-collapse" style="justify-content: end;">
                <ul class="navbar-nav" style="align-items: center;">
                    @if ($role === 'Председатель')
                        <li class="nav-item">
                            <select onchange="handleSelectChange(this);" id="selectSec">
                                <option style="padding-left: 32px" disabled selected>Председатель</option>
                                <option value="show-works">Работы</option>
                                <option value="show-experts">Эксперты</option>
                                <option data-download="/protocols/Протокол.docx">Скачать отчетный документ</option>
                            </select>
                        </li>
                        <li class="nav-item">
                            <select onchange="location = this.value; resetOptions(this);">
                                <option disabled selected>Эксперт</option>
                                <option value="e-show-works">Работы для оценивания</option>
                            </select>
                        </li>
                        <li class="nav-item">
                            <select onchange="location = this.value; resetOptions(this);">
                                <option disabled selected>Автор</option>
                                <option value="load-my-work">Загрузка работы</option>
                                <option value="my-works">Мои работы</option>
                            </select>
                        </li>
                    @endif
                    @if ($role === 'Секретарь')
                        <li class="nav-item">
                            <select onchange="handleSelectChange(this);" id="selectSec">
                                <option disabled selected>Секретарь</option>
                                <option value="show-works">Работы</option>
                                <option value="show-experts">Эксперты</option>
                                <option value="validation-works">Подтверждение работ</option>
                                <option value="meeting">Заседание и протокол</option>
                                <option data-download="/protocols/Протокол.docx">Скачать отчетный документ</option>
                            </select>
                        </li>
                        <li class="nav-item">
                            <select onchange="location = this.value; resetOptions(this);" id="selectExp">
                                <option disabled selected>Эксперт</option>
                                <option value="e-show-works">Работы для оценивания</option>
                            </select>
                        </li>
                        <li class="nav-item">
                            <select onchange="location = this.value; resetOptions(this);" id="selectAut">
                                <option disabled selected>Автор</option>
                                <option value="load-my-work">Загрузка работы</option>
                                <option value="my-works">Мои работы</option>
                            </select>
                        </li>
                    @endif
                    @if ($role === 'Эксперт')
                        <li class="nav-item">
                            <select onchange="location = this.value; resetOptions(this);">
                                <option disabled selected>Эксперт</option>
                                <option value="e-show-works">Работы для оценивания</option>
                            </select>
                        </li>
                        <li class="nav-item">
                            <select onchange="location = this.value; resetOptions(this);">
                                <option disabled selected>Автор</option>
                                <option value="load-my-work">Загрузка работы</option>
                                <option value="my-works">Мои работы</option>
                            </select>
                        </li>
                    @endif
                    @if ($role === 'Автор')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/load-my-work') }}">Загрузка работы</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/my-works') }} ">Мои работы</a>
                        </li>
                    @endif
                </ul>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" id="logout_button">Выход</button>
                </form>
            </div>
        </div>
    </nav>
</header>

<body>
    @if (isset($message))
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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
    @endif
    @if (isset($message1))
        <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center" id="exampleModalLongTitle">Заимствованный материал
                    </div>
                    <div class="modal-body" id="m1"><a href="" download></a>
                    </div>
                    <div class="modal-body" id="m2"><a href="" download></a>
                    </div>
                    <div class="modal-body" id="m3"><a href="" download></a>
                    </div>
                    <div class="modal-body" id="m4"><a href="" download></a>
                    </div>
                    <div class="modal-body" id="m5"><a href="" download></a>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" id="closeMyModal1">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if (isset($message2))
        <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center" id="exampleModalLongTitle">Оценки экспертов
                    </div>
                    <div class="modal-body" id="modalMessage2"></div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="modal fade" id="myModalLoginError1" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel" aria-hidden="true">
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
    <div class="modal fade" id="waitModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="exampleModalLongTitle">Ожидайте загрузку</h5>
                </div>
                <div class="modal-body" id="waitModalMessage">
                    <div class="loading-indicator">
                        Выполняется техническая проверка
                    </div>
                </div>
            </div>
        </div>
    </div>
    @yield('main_content')
</body>

</html>
