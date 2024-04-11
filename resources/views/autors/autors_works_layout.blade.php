@extends('autors/autors_layout')

@section('autors_main_content')
    <div class="row-container">
        <div class="column-container">
            <label>Всего работ: {{ $countAllWorks }}</label>
            <label>Проверенные работы: {{ $countAllVerifiedWorks }}</label>
            <label>Непроверенные работы: {{ $countAllUnverifiedWorks }}</label>
        </div>
        <div class="container-fluid" style="padding-top: 0px; padding-bottom: 0px;">
            <table class="table" style="margin-right: 40px">
                <thead>
                    <tr>
                        <th>№</th>
                        <th>Наименование</th>
                        <th>Предметная область</th>
                        <th>Процент оригинальности</th>
                        <th>Дата загрузки</th>
                        <th>Итоговый балл</th>
                        <th>Статус</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($worksDB as $index => $work)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><a href="#">{{ $work->name_work }}</a></td>
                            <td>{{ $work->name_subject_area }}</td>
                            <td><a href="#">{{ $work->original_percent }}%</a></td>
                            <td>{{ date('d.m.Y', strtotime($work->created_at)) }}</td>
                            <td>{{ $work->final_grade }}</td>
                            <td>{{ $work->verification_status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- <div class="container" style="justify-content: space-between; margin-left: 40px;">
        <div class="label">
            <h1>Всего работ: ...</h1>
        </div>
        <div class="label">
            <h1>Проверенные работы: ...</h1>
        </div>
        <div class="label">
            <h1>Непроверенные работы: ...</h1>
        </div>
    </div> --}}
@endsection
