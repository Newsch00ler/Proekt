@extends('admin/admin_layout')

@section('admin_main_content')
    <form method="post" action="{{ url('/admin/save-users') }}">
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
                            <th onclick="sortTable(0)">ID</th>
                            <th onclick="sortTable(1)">ФИО</th>
                            <th onclick="sortTable(2)">Роль</th>
                            <th>Логин</th>
                            <th>Пароль</th>
                        </tr>
                    </thead>
                    <tbody id="dataTable">
                        @foreach ($usersDB as $user)
                            <tr>
                                <td> {{ $user->id_user }}
                                    <input type="hidden" name="user_ids[]" value="{{ $user->id_user }}">
                                </td>
                                <td>{{ $user->full_name }}</td>
                                <td>
                                    <div style="margin: auto; width: fit-content;">
                                        <select name="roles[{{ $user->id_user }}]" class="role-select"
                                            style="text-align: center;">
                                            <option value="Администратор"
                                                {{ $user->role == 'Администратор' ? 'selected' : '' }}>Администратор
                                            </option>
                                            <option value="Автор" {{ $user->role == 'Автор' ? 'selected' : '' }}>Автор
                                            </option>
                                            <option value="Эксперт" {{ $user->role == 'Эксперт' ? 'selected' : '' }}>Эксперт
                                            </option>
                                            <option value="Председатель"
                                                {{ $user->role == 'Председатель' ? 'selected' : '' }}>
                                                Председатель</option>
                                            <option value="Секретарь" {{ $user->role == 'Секретарь' ? 'selected' : '' }}>
                                                Секретарь</option>
                                        </select>
                                    </div>
                                </td>
                                <td>{{ $user->login }}</td>
                                <td>{{ $user->password }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </form>
@endsection
