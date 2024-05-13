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
                <tbody id="dataTable">
                    @foreach ($expertsDB as $index => $expert)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $expert->full_name }}</td>
                            <td>{{ $expert->name_subject_area }}</td>
                            @if ($expert->checked_works === '0/0')
                                <td>0</td>
                            @else
                                <td>{{ $expert->checked_works }}</td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
