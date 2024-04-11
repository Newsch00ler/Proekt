@extends('main_layout')

@section('navbar_ul_content')
    <li class="nav-item">
        <a class="nav-link" href="/check-work">Проверка работ</a>
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
    @yield('experts_main_content')
@endsection
