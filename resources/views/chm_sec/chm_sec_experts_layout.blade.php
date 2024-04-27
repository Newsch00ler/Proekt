@extends('main_layout')

@section('main_content')
    <div class="row-container" style="margin-top: 42px;">
        <div class="container-fluid" style="padding-top: 0px; padding-bottom: 0px;">
            <table class="table" id="dataNameTable">
                <thead>
                    <tr>
                        <th onclick="sortTable(0)">№</th>
                        <th onclick="sortTable(1)">ФИО</th>
                        <th>Предметные области</th>
                        <th onclick="sortTable(2)">Работы</th>
                    </tr>
                </thead>
                {{-- <tbody id="dataTable">
                    @foreach ($expertsDB as $index => $expert)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $expert->full_name }}</td>
                            <td>{{ $expert->expert_subject_areas }}</td>
                            <td>{{ $expert->expert_works }}</td>
                        </tr>
                    @endforeach
                </tbody> --}}
                <tbody id="dataTable">
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
