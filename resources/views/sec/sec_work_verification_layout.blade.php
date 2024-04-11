@extends('sec/sec_layout')

@section('sec_main_content')
    <div class="row-container">
        <div class="column-container">
            <select style="margin-bottom: 42px; width: 100%;">
                <option disabled selected>Фильтровать</option>
                <option>Проверена</option>
                <option>На проверке</option>
            </select>
            <select style="margin-bottom: 42px; width: 100%;">
                <option disabled selected>Сортировать</option>
                <option>По дате</option>
                <option>По наименованию</option>
                <option>По баллу</option>
            </select>
            <input class="input" style="margin-bottom: 42px; width: 100%;" type="text" placeholder="Поиск" name="search">
        </div>
        <div class="container-fluid" style="padding-top: 0px; padding-bottom: 0px;">
            <table class="table">
                <thead>
                    <tr>
                        <th>№</th>
                        <th>Наименование</th>
                        <th>Предметная область</th>
                        <th>Процент оригинальности</th>
                        <th>Дата загрузки</th>
                        <th>Подтверждение</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td><a href="#">Сетевые игровые технологии как средство повышения эффективности учебного
                                процесса</a></td>
                        <td>Информационные технологии</td>
                        <td><a href="#">92%</a></td>
                        <td>01.12.2023</td>
                        <td><input type="checkbox" style="height: 30px; width: 30px;" name="remember" id="remember"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
