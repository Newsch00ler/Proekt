@extends('sec/sec_layout')

@section('sec_main_content')
    <div class="row-container" style="display: inline-block;">
        <div class="column-container">
            <h1 style="margin-bottom: 42px; white-space: nowrap;">Создание заседания комиссии</h1>
            <form method="post" action="{{ url('/save-date') }}">
                @csrf
                <div class="row-container" style="margin-bottom:42px; padding: 0px">
                    <label
                        style="margin: 0px; margin-right:40px; white-space: nowrap; justify-self: center; align-self: center">Выбор
                        даты</label>
                    <input type="date" name="calendar">
                </div>
                <button type="submit" style="align-items: center;">Подтвердить</button>
            </form>
        </div>
    </div>
@endsection
