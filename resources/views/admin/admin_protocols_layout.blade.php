@extends('admin/admin_layout')

@section('admin_main_content')
    <form method="post" action="{{ url('/admin/save-protocols') }}">
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
                            <th onclick="sortTable(1)">Дата заседания</th>
                            <th>Ссылка на файл протокола</th>
                            <th>Статус</th>
                        </tr>
                    </thead>
                    <tbody id="dataTable">
                        @foreach ($protocolsDB as $protocol)
                            <tr>
                                <td> {{ $protocol->id_protocol }}
                                    <input type="hidden" name="protocol_ids[]" value="{{ $protocol->id_protocol }}">
                                </td>
                                <td><input name="meeting_dates[{{ $protocol->id_protocol }}]"
                                        value="{{ $protocol->meeting_date }}"></td>
                                <td><input name="links_protocol_file[{{ $protocol->id_protocol }}]"
                                        value="{{ $protocol->link_protocol_file }}"></td>
                                <td><input name="statuses[{{ $protocol->id_protocol }}]" value="{{ $protocol->status }}">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </form>
@endsection
