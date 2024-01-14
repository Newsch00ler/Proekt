<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function showPageLogin() {
        return view('login_layout', ["title" => "Авторизация", "message"=> "Неверный логин или пароль"]);
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required'],
        ]);

        // Ищем пользователя по полю 'login'
        $user = User::where('login', $credentials['login'])->first();

        // Проверяем, существует ли пользователь и верен ли пароль
        if ($user && password_verify($credentials['password'], $user->password)) {
            if (Auth::attempt(['login' => $credentials['login'], 'password' => $credentials['password']])) {
                $request->session()->regenerate();
                return redirect('/loadMyWork');
            }
        } else {
            // Если пользователь не найден или пароль неверен, обработайте ошибку входа
            return redirect('/login')->with([
                "title" => "Авторизация", "message"=> "Неверный логин или пароль"
            ]);
        }
    }

    public function logout(Request $request) : RedirectResponse {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/login');
    }
}
