@extends('experts/experts_layout')

@section('experts_main_content')
    <div class="container" style="justify-content: space-between; margin-left: 40px;">
        <div class="label"><h1>Всего работ: </h1></div>
        <div class="label"><h1>Проверенные работы: </h1></div>
        <div class="label"><h1>Непроверенные работы: </h1></div>
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
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="font-size: 32px">1</td>
                    <td style="max-width: 200px"><a href="#">Сетевые игровые технологии как средство повышения эффективности учебного процесса</a></td>
                    <td>Информационные технологии</td>
                    <td><a href="#">92%</a></td>
                    <td>01.12.2023</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
