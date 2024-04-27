@extends('main_layout')

@section('main_content')
    <div class="row-container" style="margin-top: 42px;">
        <div class="column-container">
            <label>Всего работ: {{ $countAllWorks }}</label>
            <label>Проверенные работы: {{ $countAllVerifiedWorks }}</label>
            <label>Непроверенные работы: {{ $countAllUnverifiedWorks }}</label>
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
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
