@extends('main_layout')

@section('main_content')
    <div class="container-fluid" style="display: inline-block;">
        <h1 style="margin-bottom: 42px; display: flex;">Создание заседания комиссии</h1>
        <form method="post" action="{{ url('/save-date') }}">
            @csrf
            <div class="row-container" style="margin-bottom:42px; padding: 0px">
                <label
                    style="margin: 0px; margin-right: 40px; white-space: nowrap; justify-self: center; align-self: center">Выбор
                    даты</label>
                <input type="date" name="calendar" min="{{ date('Y-m-d') }}" value="{{ $dateFormatted }}">
            </div>
            <button type="submit" style="align-items: center;" id="submitDateButton"> {{ $textButton }}</button>
        </form>
    </div>
@endsection
