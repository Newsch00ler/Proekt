@extends('errors.error_layout')

@section('error_content')
    <div style="text-align: center; margin-left: 20%; margin-right: 20%;">
        <h1>404 Страница не найдена</h1>
        <hr style="border: 0; height: 2px; background-color: white;">
        <h3>К сожалению, запрашиваемая вами страница не найдена. Возможно, вы ошиблись
            в адресе страницы или страница была
            перемещена. Пожалуйста, проверьте URL и попробуйте еще раз.</h3>
        <hr style="border: 0; height: 2px; background-color: white;">
        {{-- <h2><a href="{{ url('/logout') }}" style="color: white; text-decoration: underline">Попробуйте войти в систему</a>
        </h2> --}}
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button type="submit"
                style="font-size: 24px; padding: 0; background: none; border: none; color: white; text-decoration: underline; cursor: pointer;">Попробуйте
                войти в систему</button>
        </form>
    </div>
@endsection
