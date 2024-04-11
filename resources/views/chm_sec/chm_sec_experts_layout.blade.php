@extends('chm_sec/chm_sec_layout')

@section('chm_sec_main_content')
    <div class="row-container">
        <div class="container-fluid" style="padding-top: 0px; padding-bottom: 0px;">
            <table class="table">
                <thead>
                    <tr>
                        <th>№</th>
                        <th>ФИО</th>
                        <th>Предметные области</th>
                        <th>Работы</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td><a href="#">Иванов Иван Иванович</a></td>
                        <td>Информационные технологии, Математика</td>
                        <td>1/2</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td><a href="#">Петров Петр Петрович</a></td>
                        <td>Экономика, Математика</td>
                        <td>0/5</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
