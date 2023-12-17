@extends('main_layout')

@section('navbar_ul_content')
    <li class="nav-item">
        <select>
            <option disabled selected>Предс/Секр</option>
            <option>Работы</option>
            <option>Эксперты</option>
            <option>Скачать отчетный документ</option>
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
    @yield('chm_sec_main_content')
@endsection
