@extends('experts/experts_layout')

@section('experts_main_content')
    <div class="row-container">
        <div class="column-container">
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
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td style="max-width: 200px"><a href="#">Сетевые игровые технологии как средство повышения
                                эффективности учебного процесса</a></td>
                        <td>Информационные технологии</td>
                        <td><a href="#">92%</a></td>
                        <td>01.12.2023</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
