@extends('chm_sec/chm_sec_layout')

@section('chm_sec_main_content')
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
            <label>Всего работ: </label>
            <label>Проверенные работы: </label>
            <label>Непроверенные работы: </label>
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
                        <th>Итоговый балл</th>
                        <th>Проверяющие</th>
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
                        <td>28</td>
                        <td>Иванов И.И.<br>Петров П.П.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
