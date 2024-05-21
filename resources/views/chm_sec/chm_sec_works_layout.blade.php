@extends('main_layout')

@section('main_content')
    <div class="row-container" style="margin-top: 42px;">
        <div class="column-container">
            <select style="margin-bottom: 42px; width: 100%;" id="statusSelect" onchange="filterTableByStatus()">
                <option disabled selected>Фильтровать</option>
                <option>Внесена в протокол</option>
                <option>Проверена</option>
                <option value="check">На проверке</option>
                <option>Не подтверждена</option>
                <option>Отклонена</option>
                <option>Сбросить</option>
            </select>
            <input class="input" type="text" id="searchInput" name="search" autocomplete="off" onkeyup="filterTable()"
                style="margin-bottom: 42px; width: 100%;" placeholder="Поиск">
            <label>Всего работ: {{ $countAllWorks }}</label>
            <label>Проверенные работы: {{ $countAllVerifiedWorks }}</label>
            <label>Непроверенные работы: {{ $countAllUnverifiedWorks }}</label>
            <label>Отклоненные работы: {{ $countAllRejectedWorks }}</label>
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
                        <th onclick="sortTable(6)">Статус</th>
                        <th>Проверяющие</th>
                    </tr>
                </thead>
                <tbody id="dataTable">
                    @foreach ($worksDB as $index => $work)
                        <tr>
                            @if ($work->original_percent < 61)
                                <td class="yelowwTd">{{ $index + 1 }}</td>
                                <td class="yelowwTd">
                                    <a href="/loadPdfFiles/{{ $work->file_name }}" download>{{ $work->name_work }}</a>
                                </td>
                                <td class="yelowwTd">{{ $work->name_subject_area }}</td>
                                <td class="yelowwTd">
                                    <a class="redA" href=""
                                        onclick="openModal1(event, {{ json_encode($message1[$index]) }})">
                                        {{ $work->original_percent }}%
                                    </a>
                                </td>
                                <td class="yelowwTd">{{ date('d.m.Y', strtotime($work->created_at)) }}</td>
                                <td class="yelowwTd">
                                    <a href="" onclick="openModal2(event, '{{ $message2[$index] }}')">
                                        {{ $work->final_grade }}
                                    </a>
                                </td>
                                <td class="yelowwTd">{{ $work->status }}</td>
                                @if ($work->status === 'Не подтверждена')
                                    <td class="yelowwTd"></td>
                                @else
                                    <td class="yelowwTd">{{ $work->experts }}</td>
                                @endif
                            @else
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <a href="/loadPdfFiles/{{ $work->file_name }}" download>{{ $work->name_work }}</a>
                                </td>
                                <td>{{ $work->name_subject_area }}</td>
                                <td>
                                    <a href="" onclick="openModal1(event, {{ json_encode($message1[$index]) }})">
                                        {{ $work->original_percent }}%
                                    </a>
                                </td>
                                <td>{{ date('d.m.Y', strtotime($work->created_at)) }}</td>
                                <td>
                                    <a href="" onclick="openModal2(event, '{{ $message2[$index] }}')">
                                        {{ $work->final_grade }}
                                    </a>
                                </td>
                                <td>{{ $work->status }}</td>
                                @if ($work->status === 'Не подтверждена' || $work->status === 'Отклонена')
                                    <td></td>
                                @else
                                    <td>{{ $work->experts }}</td>
                                @endif
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
