@extends('errors.error_layout')

@section('error_content')
    <div style="text-align: center; margin-left: 20%; margin-right: 20%;">
        <h1>500 Внутренняя ошибка сервера</h1>
        <hr style="border: 0; height: 2px; background-color: white;">
        <h3>Произошла внутренняя ошибка сервера. Наша команда уже работает над её исправлением. Пожалуйста, повторите
            попытку позже.</h3>
        <hr style="border: 0; height: 2px; background-color: white;">
        <h2><a href="{{ url('/login') }}" style="color: white; text-decoration: underline">Попробуйте войти в систему</a></h2>
    </div>
@endsection
