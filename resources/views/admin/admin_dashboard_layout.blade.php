@extends('admin/admin_layout')

@section('admin_main_content')
    <div class="fluid-container" style="margin: 2%; display: grid;">
        <h1 style="margin-bottom: 2%;">Панель управления</h1>
        <div class="row-container" style="padding: 0%;">
            {{-- <div class="card" style="margin-right: 2%;">
                <h2 class="card-header" style="color: #1E6C8C;">Обзор</h2>
                <div class="card-body">
                    <h3 style="color: #1E6C8C;">Можно добавить общую информацию<br>или статистику если надо</h3>
                </div>
            </div> --}}
            <div class="card" style="margin-right: 2%;">
                <h2 class="card-header" style="color: #1E6C8C;">Быстрый доступ</h2>
                <div class="card-body">
                    <ul style="margin: 0; padding: 0;">
                        <li class="nav-link" style="margin: 0; padding: 0;">
                            <h3><a href="/admin/users" style="color: #1E6C8C;">Управление пользователями</a></h3>
                        </li>
                        <li class="nav-link" style="margin-top: 2%; padding: 0;">
                            <h3><a href="/admin/works" style="color: #1E6C8C;">Управление работами</a></h3>
                        </li>
                        <li class="nav-link" style="margin-top: 2%; padding: 0;">
                            <h3><a href="/admin/protocols" style="color: #1E6C8C;">Управление протоколами</a></h3>
                        </li>
                        <li class="nav-link" style="margin-top: 2%; padding: 0;">
                            <h3><a href="/admin/check-works" style="color: #1E6C8C;">Управление оценками работ</a></h3>
                        </li>
                        <li class="nav-link" style="margin-top: 2%; padding: 0;">
                            <h3><a href="/admin/subject-areas" style="color: #1E6C8C;">Управление предметными областями</a>
                            </h3>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card" style="margin-right: 2%;">
                <h2 class="card-header" style="color: #1E6C8C;">Дата заседания</h2>
                <div class="card-body">
                    <form method="post" action="{{ url('/admin/save-date') }}">
                        @csrf
                        <div class="row-container" style="margin-bottom: 2%; padding: 0px">
                            <h3
                                style="margin: 0px; margin-right: 40px; white-space: nowrap; justify-self: center; align-self: center; color: #1E6C8C;">
                                Выбор
                                даты</h3>
                            <input style="background: #1E6C8C; font-size: 18px;" type="date" name="calendar"
                                min="{{ date('Y-m-d') }}" value="{{ $dateFormatted }}">
                        </div>
                        <button type="submit" style="align-items: center; background: #1E6C8C; font-size: 18px;"
                            id="submitDateButton">
                            {{ $textButton }}</button>
                    </form>
                </div>
            </div>
            <div class="card" style="margin-right: 2%;">
                <h2 class="card-header" style="color: #1E6C8C;">Выгрузка файлов методического<br>материала из электронной
                    библиотеки ИРНИТУ</h2>
                <div class="card-body">
                    <button type="submit" style="align-items: center; background: #1E6C8C; font-size: 18px;">
                        Выгрузить
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
