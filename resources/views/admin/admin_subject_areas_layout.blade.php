@extends('admin/admin_layout')

@section('admin_main_content')
    <form method="post" action="{{ url('/admin/save-subject-areas') }}">
        @csrf
        <div class="row-container" style="margin-top: 42px;">
            <div class="column-container">
                <input class="input" type="text" id="searchInput" name="search" autocomplete="off" onkeyup="filterTable()"
                    style="background: #1E6C8C; margin-bottom: 42px; width: 100%;" placeholder="Поиск">
                <button style="background: #1E6C8C; margin-top: 3%" type="submit">Сохранить</button>
            </div>
            <div class="container-fluid" style="padding-top: 0px; padding-bottom: 0px;">
                <table class="table small" id="dataNameTable">
                    <thead>
                        <tr>
                            <th onclick="sortTable(0)" style="font-size: 20px; padding-left: 5px">ID</th>
                            <th onclick="sortTable(1)" style="font-size: 20px;">Наименование</th>
                        </tr>
                    </thead>
                    <tbody id="dataTable">
                        @foreach ($subject_areasDB as $subject_area)
                            <tr>
                                <td style="font-size: 20px;"> {{ $subject_area->id_subject_area }}
                                    <input type="hidden" name="subject_area_ids[]"
                                        value="{{ $subject_area->id_subject_area }}">
                                </td>
                                <td style="font-size: 20px;"><input name="names_subject_area[]"
                                        value="{{ $subject_area->name_subject_area }}"></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </form>
@endsection
