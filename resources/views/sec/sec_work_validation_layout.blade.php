@extends('main_layout')

@section('main_content')
    <form method="post" action="{{ url('/save-validation') }}">
        @csrf
        <div class="row-container" style="margin-top: 42px;">
            <div class="column-container">
                <input class="input" type="text" id="searchInput" name="search" autocomplete="off" onkeyup="filterTable()"
                    style="margin-bottom: 42px; width: 100%;" placeholder="Поиск">
                <button style="margin-top: 3%" type="submit">Подтвердить</button>
            </div>
            <div class="container-fluid" style="padding-top: 0px; padding-bottom: 0px;">
                <table class="table" id="dataNameTable">
                    <thead>
                        <tr>
                            <th onclick="sortTable(0)">№</th>
                            <th onclick="sortTable(1)">Наименование</th>
                            <th onclick="sortTable(2)">Предметная область</th>
                            <th onclick="sortTable(3)">Процент оригинальности</th>
                            <th onclick="sortTable(4)">Дата загрузки</th>
                            <th>Подтверждение</th>
                        </tr>
                    </thead>
                    <tbody id="dataTable">
                        {{-- @foreach ($worksDB as $index => $work)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><a href="#">{{ $work->id_subject_area }}</a></td>
                                <td>{{ $work->name_subject_area }}</td>
                            </tr>
                        @endforeach --}}
                        @foreach ($worksDB as $index => $work)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><a href="#">{{ $work->name_work }}</a></td>
                                <td>{{ $work->name_subject_area }}</td>
                                <td><a href="#">{{ $work->original_percent }}%</a></td>
                                <td>{{ date('d.m.Y', strtotime($work->created_at)) }}</td>
                                <td>
                                    <input type="checkbox" style="height: 30px; width: 30px;" name="work_ids[]"
                                        value="{{ $work->id_work }}">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </form>
@endsection
