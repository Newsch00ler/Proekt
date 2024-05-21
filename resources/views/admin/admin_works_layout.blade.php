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
                            <th onclick="sortTable(1)">Наим.</th>
                            <th>Язык</th>
                            <th>Творч.</th>
                            <th>Статус</th>
                            <th>Вид</th>
                            <th>Оценка</th>
                            <th>ID пр.</th>
                            <th>% ориг.</th>
                            <th>Дата загрузки</th>
                            <th>Издатель</th>
                            <th>Стр.</th>
                            <th>Дата изд.</th>
                            <th>Ссылка на файл выписки</th>
                            <th>Ссылка на pdf файл</th>
                            <th>Ссылка на txt файл</th>
                            <th>Файл1</th>
                            <th>Файл2</th>
                            <th>Файл3</th>
                            <th>Файл4</th>
                            <th>Файл5</th>
                            <th>Процент1</th>
                            <th>Процент2</th>
                            <th>Процент3</th>
                            <th>Процент4</th>
                            <th>Процент5</th>
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
                                <td>
                                    <div style="margin: auto; width: fit-content;">
                                        <select name="languages[{{ $work->id_work }}]" class="type-select">
                                            <option value="" {{ $work->language == '' ? 'selected' : '' }}></option>
                                            <option value="Russian" {{ $work->language == 'Russian' ? 'selected' : '' }}>
                                                Русский
                                            </option>
                                            <option value="Foreign" {{ $work->language == 'Foreign' ? 'selected' : '' }}>
                                                Иностранный</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <input name="creatives[{{ $work->id_work }}]" type="checkbox"
                                        style="height: 20px; width: 20px; align-self: center"
                                        {{ $work->creative ? 'checked' : '' }}>
                                </td>
                                <td>
                                    <div style="margin: auto; width: fit-content;">
                                        <select name="statuses[{{ $work->id_work }}]" class="status-select">
                                            <option value="" {{ $work->status == '' ? 'selected' : '' }}></option>
                                            <option value="Не подтверждена"
                                                {{ $work->status == 'Не подтверждена' ? 'selected' : '' }}>
                                                Не подтверждена
                                            </option>
                                            <option value="На проверке"
                                                {{ $work->status == 'На проверке' ? 'selected' : '' }}>
                                                На проверке</option>
                                            <option value="Внесена в протокол"
                                                {{ $work->status == 'Внесена в протокол' ? 'selected' : '' }}>
                                                Внесена в протокол
                                            </option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div style="margin: auto; width: fit-content;">
                                        <select name="types[{{ $work->id_work }}]" class="type-select">
                                            <option value="" {{ $work->type == '' ? 'selected' : '' }}></option>
                                            <option value="Учебник с грифом"
                                                {{ $work->type == 'Учебник с грифом' ? 'selected' : '' }}>
                                                Учебник с грифом
                                            </option>
                                            <option value="Учебное пособие с грифом"
                                                {{ $work->type == 'Учебное пособие с грифом' ? 'selected' : '' }}>
                                                Учебное
                                                пособие с грифом</option>
                                            <option value="Учебное пособие"
                                                {{ $work->type == 'Учебное пособие' ? 'selected' : '' }}>
                                                Учебное пособие
                                            </option>
                                            <option value="Сборник задач"
                                                {{ $work->type == 'Сборник задач' ? 'selected' : '' }}>
                                                Сборник задач</option>
                                            <option value="Практикум / лабораторный практикум"
                                                {{ $work->type == 'Практикум / лабораторный практикум' ? 'selected' : '' }}>
                                                Практикум / лабораторный практикум</option>
                                            <option value="Творческая работа"
                                                {{ $work->type == 'Творческая работа' ? 'selected' : '' }}>
                                                Творческая работа</option>
                                        </select>
                                    </div>
                                </td>
                                <td><input name="final_grades[{{ $work->id_work }}]" value="{{ $work->final_grade }}">
                                </td>
                                <td><input name="ids_protocol[{{ $work->id_work }}]" value="{{ $work->id_protocol }}">
                                </td>
                                <td><input name="original_percents[{{ $work->id_work }}]"
                                        value="{{ $work->original_percent }}"></td>
                                <td><input name="created_at[{{ $work->id_work }}]" value="{{ $work->created_at }}"></td>
                                <td><input name="publishers[{{ $work->id_work }}]" value="{{ $work->publisher }}">
                                </td>
                                <td><input name="pages[{{ $work->id_work }}]" value="{{ $work->pages_number }}">
                                </td>
                                <td><input name="publish_dates[{{ $work->id_work }}]"
                                        value="{{ $work->publishing_year }}">
                                </td>
                                <td><input name="links_file_extract_protocol[{{ $work->id_work }}]"
                                        value="{{ $work->link_file_extract_protocol }}"></td>
                                <td><input name="links_pdf_file[{{ $work->id_work }}]" value="{{ $work->link_pdf_file }}">
                                </td>
                                <td><input name="links_text_file[{{ $work->id_work }}]"
                                        value="{{ $work->link_text_file }}"></td>
                                <td><input name="links_text_percent1[{{ $work->id_work }}]"
                                        value="{{ $work->link_text_percent1 }}"></td>
                                <td><input name="links_text_percent2[{{ $work->id_work }}]"
                                        value="{{ $work->link_text_percent2 }}"></td>
                                <td><input name="links_text_percent3[{{ $work->id_work }}]"
                                        value="{{ $work->link_text_percent3 }}"></td>
                                <td><input name="links_text_percent4[{{ $work->id_work }}]"
                                        value="{{ $work->link_text_percent4 }}"></td>
                                <td><input name="links_text_percent5[{{ $work->id_work }}]"
                                        value="{{ $work->link_text_percent5 }}"></td>
                                <td><input name="percents1[{{ $work->id_work }}]" value="{{ $work->percent1 }}">
                                </td>
                                <td><input name="percents2[{{ $work->id_work }}]" value="{{ $work->percent2 }}">
                                </td>
                                <td><input name="percents3[{{ $work->id_work }}]" value="{{ $work->percent3 }}">
                                </td>
                                <td><input name="percents4[{{ $work->id_work }}]" value="{{ $work->percent4 }}">
                                </td>
                                <td><input name="percents5[{{ $work->id_work }}]" value="{{ $work->percent5 }}">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </form>
@endsection
