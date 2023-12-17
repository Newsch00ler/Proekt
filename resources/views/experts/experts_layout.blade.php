@extends('main_layout')

@section('navbar_ul_content')
    <li class="nav-item">
        <a class="nav-link" href="#">Проверка работ</a>
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
    @yield('experts_main_content')
@endsection
