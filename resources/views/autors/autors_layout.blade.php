@extends('main_layout')

@section('navbar_ul_content')
    <li class="nav-item">
        <a class="nav-link" href="#">Загрузка работ</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">Мои работы</a>
    </li>
@endsection

@section('main_content')
    @yield('autors_main_content')
@endsection
