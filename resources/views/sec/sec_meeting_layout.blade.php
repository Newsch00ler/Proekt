@extends('main_layout')

@section('main_content')
    <div class="container-fluid" style="display: inline-block; <?php if (!$isVisible1) {
        echo 'display: none;';
    } ?>">
        <h1 style="margin-bottom: 42px; display: flex;">Заседание комиссии</h1>
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
    <div class="container-fluid" style="display: inline-block; <?php if (!$isVisible2) {
        echo 'display: none;';
    } ?>">
        <h1 style="margin-bottom: 42px; display: flex;">Результаты заседания</h1>
        <label style="margin-bottom: 42px; display: flex;">Необходимо подтвердить результаты заседания</label>
        <div class="row-container" style="margin-bottom:42px; padding: 0px">
            <form method="post" action="{{ url('/approve-protocol') }}">
                @csrf
                <button type="submit" style="align-items: center; margin-right: 42px" id="submitProtocolButton1">
                    Утвердить</button>
            </form>
            <form method="post" action="{{ url('/not-approve-protocol') }}">
                @csrf
                <button type="submit" style="align-items: center;" id="submitProtocolButton2"> Не утвердить </button>
            </form>
        </div>

    </div>
@endsection
