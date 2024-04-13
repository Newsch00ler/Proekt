@extends('sec/sec_layout')

@section('sec_main_content')
    <form method="post" action="{{ url('/save-validation') }}">
        @csrf
        <div class="row-container">
            <div class="column-container">
                <select style="margin-bottom: 42px; width: 100%;">
                    <option disabled selected>Фильтровать</option>
                    <option>Проверена</option>
                    <option>На проверке</option>
                </select>
                <select style="margin-bottom: 42px; width: 100%;">
                    <option disabled selected>Сортировать</option>
                    <option>По дате</option>
                    <option>По наименованию</option>
                    <option>По баллу</option>
                </select>
                <input class="input" style="margin-bottom: 42px; width: 100%;" type="text" placeholder="Поиск"
                    name="search">
                <button style="margin-top: 3%" type="submit">Подтвердить</button>
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
                            <th>Подтверждение</th>
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
