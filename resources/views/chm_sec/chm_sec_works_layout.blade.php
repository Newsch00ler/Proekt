@extends('main_layout')

@section('main_content')
    <div class="row-container" style="margin-top: 42px;">
        <div class="column-container">
            <select style="margin-bottom: 42px; width: 100%;">
                <option disabled selected>Фильтровать</option>
                <option>Проверена</option>
                <option>На проверке</option>
            </select>
            <input class="input" type="text" id="searchInput" name="search" autocomplete="off" onkeyup="filterTable()"
                style="margin-bottom: 42px; width: 100%;" placeholder="Поиск">
            <label>Всего работ: {{ $countAllWorks }}</label>
            <label>Проверенные работы: {{ $countAllVerifiedWorks }}</label>
            <label>Непроверенные работы: {{ $countAllUnverifiedWorks }}</label>
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
                        <th onclick="sortTable(5)">Итоговый балл</th>
                        <th>Проверяющие</th>
                    </tr>
                </thead>
                <tbody id="dataTable">
                    @foreach ($worksDB as $index => $work)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <a href="/loadPdfFiles/{{ $work->file_name }}" download>{{ $work->name_work }}</a>
                            </td>
                            <td>{{ $work->name_subject_area }}</td>
                            <td>
                                <a href="#" onclick="openModal(event, '{{ $message1 }}', '{{ $link }}')">
                                    {{ $work->original_percent }}%
                                </a>
                            </td>
                            <td>{{ date('d.m.Y', strtotime($work->created_at)) }}</td>
                            <td>
                                <a href="#" onclick="openModal(event, '{{ $message2 }}')">
                                    {{ $work->final_grade }}
                                </a>
                            </td>
                            <td>Проверяющие</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
