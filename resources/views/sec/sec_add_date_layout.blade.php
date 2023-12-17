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
    <div class="container" style="margin-top: 12%; flex-direction: column;">
        <h1 style="margin-bottom: 5%;">Создание заседания комиссии</h1>
        <div class="container" style="margin-bottom: 5%; flex-direction: row;">
            <h2 style="margin-right: 32px;">Выбор даты</h2>
            <form>
                <input type="date" name="calendar">
            </form>
        </div>
        <button type="submit">Подтвердить</button>
    </div>
@endsection
