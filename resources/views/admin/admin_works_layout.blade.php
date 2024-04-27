@extends('admin/admin_layout')

@section('admin_main_content')
    <form method="post" action="{{ url('/admin/save-works') }}">
        @csrf
        <div class="row-container" style="margin-top: 42px;">
            <div class="column-container">
                <input class="input" type="text" id="searchInput" name="search" autocomplete="off" onkeyup="filterTable()"
                    style="background: #1E6C8C; margin-bottom: 42px; width: 100%;" placeholder="Поиск">
                <button style="background: #1E6C8C; margin-top: 3%" type="submit">Сохранить</button>
            </div>
            <div class="container-fluid" style="padding-top: 0px; padding-bottom: 0px;">
                <table class="table" id="dataNameTable">
                    <thead>
                        <tr>
                            <th onclick="sortTable(0)" style="padding-left: 5px">ID</th>
                            <th onclick="sortTable(1)">Наименование</th>
                            <th>Язык</th>
                            <th>Творческая</th>
                            <th>Гриф</th>
                            <th>Статус проверки</th>
                            <th>ID протокола</th>
                            <th>Процент оригинальности</th>
                            <th>Дата загрузки</th>
                            <th>Ссылка из эл. библиотеки</th>
                            <th>Ссылка на файл выписки</th>
                            <th>Ссылка на текст. файл</th>
                            <th>Одобрение</th>
                        </tr>
                    </thead>
                    <tbody id="dataTable">
                        @foreach ($worksDB as $work)
                            <tr>
                                <td> {{ $work->id_work }}
                                    <input type="hidden" name="work_ids[]" value="{{ $work->id_work }}">
                                </td>
                                <td>
                                    <input name="names[{{ $work->id_work }}]" value="{{ $work->name_work }}">
                                </td>
                                <td><input name="languages[{{ $work->id_work }}]" value="{{ $work->language }}"></td>
                                <td>
                                    <input name="creatives[{{ $work->id_work }}]" type="checkbox"
                                        style="height: 20px; width: 20px; align-self: center"
                                        {{ $work->creative ? 'checked' : '' }}>
                                </td>
                                <td>
                                    <div style="margin: auto; width: fit-content;">
                                        <select name="signatures[{{ $work->id_work }}]" class="signature-select">
                                            <option value="" {{ $work->signature == '' ? 'selected' : '' }}></option>
                                            <option value="Учебник с грифом"
                                                {{ $work->signature == 'Учебник с грифом' ? 'selected' : '' }}>
                                                Учебник с грифом
                                            </option>
                                            <option value="Учебное пособие с грифом"
                                                {{ $work->signature == 'Учебное пособие с грифом' ? 'selected' : '' }}>
                                                Учебное
                                                пособие с грифом</option>
                                            <option value="Учебное пособие"
                                                {{ $work->signature == 'Учебное пособие' ? 'selected' : '' }}>
                                                Учебное пособие
                                            </option>
                                            <option value="Сборник задач"
                                                {{ $work->signature == 'Сборник задач' ? 'selected' : '' }}>
                                                Сборник задач</option>
                                            <option value="Практикум / лабораторный практикум"
                                                {{ $work->signature == 'Практикум / лабораторный практикум' ? 'selected' : '' }}>
                                                Практикум / лабораторный практикум</option>
                                            <option value="Творческая работа"
                                                {{ $work->signature == 'Творческая работа' ? 'selected' : '' }}>
                                                Творческая работа</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <input name="verification_statuses[{{ $work->id_work }}]" type="checkbox"
                                        style="height: 20px; width: 20px;"
                                        {{ $work->verification_status ? 'checked' : '' }}>
                                </td>
                                <td><input name="ids_protocol[{{ $work->id_work }}]" value="{{ $work->id_protocol }}">
                                </td>
                                <td><input name="original_percentes[{{ $work->id_work }}]"
                                        value="{{ $work->original_percent }}"></td>
                                <td><input name="created_at[{{ $work->id_work }}]" value="{{ $work->created_at }}"></td>
                                <td><input name="links_library[{{ $work->id_work }}]" value="{{ $work->link_library }}">
                                </td>
                                <td><input name="links_file_extract_protocol[{{ $work->id_work }}]"
                                        value="{{ $work->link_file_extract_protocol }}"></td>
                                <td><input name="links_text_file[{{ $work->id_work }}]"
                                        value="{{ $work->link_text_file }}"></td>
                                <td>
                                    <input name="validations[{{ $work->id_work }}]" type="checkbox"
                                        style="height: 20px; width: 20px;" {{ $work->validation ? 'checked' : '' }}>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </form>
@endsection
