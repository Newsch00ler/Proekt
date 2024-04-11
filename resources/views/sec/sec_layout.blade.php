@extends('main_layout')

@section('navbar_ul_content')
    <li class="nav-item">
        <select onchange="location = this.value;">
            <option disabled selected>Секретарь</option>
            <option value="show-works">Работы</option>
            <option value="show-experts">Эксперты</option>
            <option value="verification-works">Подтверждение работ</option>
            <option value="save-date">Добавление заседания</option>
            <option value="#">Скачать отчетный документ</option>
        </select>
    </li>
    <li class="nav-item">
        <select onchange="location = this.value;">
            <option disabled selected>Автор</option>
            <option value="load-my-work">Загрузка работ</option>
            <option value="show-works">Мои работы</option>
        </select>
    </li>
@endsection

@section('main_content')
    @yield('sec_main_content')
@endsection
