<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ErrorController extends Controller
{
    public function show404()
    {
        if (Auth::check()) {
            return redirect()->back()->with(["error" => "К сожалению, запрашиваемая вами страница не найдена. Пожалуйста, проверьте URL и попробуйте еще раз."]);
        } else {
            Auth::logout();
            return redirect()->back()->with(["error" => "Для перехода на данную страницу необходима авторизация."]);
        }
    }

    public function show500()
    {
        if (Auth::check()) {
            return redirect()->back()->with(["error" => "Произошла внутренняя ошибка сервера. Пожалуйста, повторите попытку позже."]);
        } else {
            Auth::logout();
            return redirect()->back()->with(["error" => "Произошла внутренняя ошибка сервера. Пожалуйста, повторите попытку позже."]);
        }
    }

    public function show503()
    {
        if (Auth::check()) {
            return redirect()->back()->with(["error" => "Сервис временно недоступен из-за технических работ или перегрузки сервера. Пожалуйста, повторите попытку позже."]);
        } else {
            Auth::logout();
            return redirect()->back()->with(["error" => "Сервис временно недоступен из-за технических работ или перегрузки сервера. Пожалуйста, повторите попытку позже."]);
        }
    }
}
