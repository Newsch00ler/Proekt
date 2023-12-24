@extends('main_layout')

@section('navbar_ul_content')
<li class="nav-item">
    <select>
        <option disabled selected>Секретарь</option>
        <option>Работы</option>
        <option>Эксперты</option>
        <option>Скачать отчетный документ</option>
        <option>Добавление заседания</option>
    </select>
</li>
<li class="nav-item">
    <select>
        <option disabled selected>Автор</option>
        <option>Загрузка работ</option>
        <option>Мои работы</option>
    </select>
</li>
@endsection

@section('main_content')
    @yield('sec_main_content')
@endsection
