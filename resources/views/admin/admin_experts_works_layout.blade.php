@extends('admin/admin_layout')

@section('admin_main_content')
    <form method="post" action="{{ url('/admin/save-check-works') }}">
        @csrf
        <div class="row-container" style="margin-top: 42px;">
            <div class="column-container">
                <input class="input" type="text" id="searchInput" name="search" autocomplete="off" onkeyup="filterTable()"
                    style="background: #1E6C8C; margin-bottom: 42px; width: 100%;" placeholder="Поиск">
                <button style="background: #1E6C8C; margin-top: 3%" type="submit">Сохранить</button>
            </div>
            <div class="container-fluid" style="padding-top: 0px; padding-bottom: 0px;">
                <table class="table small" id="dataNameTable">
                    <thead style="font-size: 18px;">
                        <tr>
                            <th onclick="sortTable(0)" style="padding-left: 5px">Эксперт (ID/ФИО)</th>
                            <th onclick="sortTable(1)">Работа (ID/Наименование)</th>
                            <th>Критерий 1</th>
                            <th>Критерий 2</th>
                            <th>Критерий 3</th>
                            <th>Критерий 4</th>
                            <th>Критерий 5</th>
                        </tr>
                    </thead>
                    <tbody id="dataTable">
                        @foreach ($experts_worksDB as $index => $experts_works)
                            <tr>
                                <td> {{ $experts_works->id_user }}-{{ $full_names_expertsDB[$index]->full_name }}
                                    <input type="hidden" name="user_ids[]" value="{{ $experts_works->id_user }}">
                                </td>
                                <td> {{ $experts_works->id_work }}-"{{ $names_worksDB[$index]->name_work }}"
                                    <input type="hidden" name="work_ids[]" value="{{ $experts_works->id_work }}">
                                </td>
                                <td><input name="criterions1[]" value="{{ $experts_works->criterion1 }}"></td>
                                <td><input name="criterions2[]" value="{{ $experts_works->criterion2 }}"></td>
                                <td><input name="criterions3[]" value="{{ $experts_works->criterion3 }}"></td>
                                <td><input name="criterions4[]" value="{{ $experts_works->criterion4 }}"></td>
                                <td><input name="criterions5[]" value="{{ $experts_works->criterion5 }}"></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </form>
@endsection
