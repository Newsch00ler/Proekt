@extends('chm_sec/chm_sec_layout')

@section('chm_sec_main_content')
    <div class="container-fluid" style="display: flex; padding: 0px;">
        <div class="container" style="justify-content: space-between; margin-left: 40px;">
            <h1 style="margin-right: 50px">Всего работ: </h1>
            <h1 style="margin-right: 50px">Проверенные работы: </h1>
            <h1>Непроверенные работы: </h1>
        </div>
        <div class="container" style="justify-content: end; margin-right: 40px; display: inline-flex;">
            <input class="input" style="margin-right: 50px;" type="text" placeholder="Поиск" name="search">
            <select>
                <option disabled selected>Фильтровать</option>
                <option>По дате</option>
                <option>По наименованию</option>
                <option>По баллу</option>
            </select>
        </div>
    </div>
    <div class="container-fluid" style="padding-left: 40px; padding-right: 40px;">
        <table class="table" style="margin-right: 40px">
            <thead>
                <tr>
                    <th>№</th>
                    <th>Наименование</th>
                    <th>Предметная область</th>
                    <th>Процент оригинальности</th>
                    <th>Дата загрузки</th>
                    <th>Итоговый балл</th>
                    <th>Проверяющие</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="font-size: 32px">1</td>
                    <td><a href="#">Сетевые игровые технологии как средство повышения эффективности учебного процесса</a></td>
                    <td>Информационные технологии</td>
                    <td><a href="#">92%</a></td>
                    <td>01.12.2023</td>
                    <td>28</td>
                    <td>Иванов И.И.<br>Петров П.П.</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
