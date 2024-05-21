@extends('main_layout')

@section('main_content')
    <div class="row-container" style="margin-top: 42px;">
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
                    @foreach ($worksForCheck as $index => $work)
                        <tr>
                            @if ($work->original_percent < 61)
                                <td class="yelowwTd">{{ $index + 1 }}</td>
                                <td class="yelowwTd">
                                    <a href="{{ url('/check-work?id=' . $work->id_work) }}">{{ $work->name_work }}</a>
                                </td>
                                <td class="yelowwTd">{{ $work->name_subject_area }}</td>
                                <td class="yelowwTd">
                                    <a class="redA" href=""
                                        onclick="openModal1(event, {{ json_encode($message1[$index]) }})">
                                        {{ $work->original_percent }}%
                                    </a>
                                </td>
                                <td class="yelowwTd">{{ date('d.m.Y', strtotime($work->created_at)) }}</td>
                            @else
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <a href="{{ url('/check-work?id=' . $work->id_work) }}">{{ $work->name_work }}</a>
                                </td>
                                <td>{{ $work->name_subject_area }}</td>
                                <td>
                                    <a href="" onclick="openModal1(event, {{ json_encode($message1[$index]) }})">
                                        {{ $work->original_percent }}%
                                    </a>
                                </td>
                                <td>{{ date('d.m.Y', strtotime($work->created_at)) }}</td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
