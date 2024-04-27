<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\User;
use DateTime;

class LoginController extends Controller
{
    public function showPageLogin() {
        $filePath = storage_path('date.txt');
        if (File::size($filePath) !== 0) {
            $date = File::get($filePath);
            $date = new DateTime($date);
            $formattedDate = $date->format('d.m.Y');
            $currentDate = new DateTime();
            $formattedCurrentDate = $currentDate->format('d.m.Y');
            if ($formattedDate === $formattedCurrentDate) {
                file_put_contents($filePath, '');
            }
        }
        return view('login_layout', ["title" => "Авторизация", "message"=> "Введите данные для входа"]);
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required'],
        ]);
        $user = User::where('login', $credentials['login'])->first();
        if ($user && password_verify($credentials['password'], $user->password)) {
            if (Auth::attempt(['login' => $credentials['login'], 'password' => $credentials['password']])) {
                $request->session()->regenerate();
                if ($user->isRole() === "Администратор") {
                    $token = $user->createToken('AppName')->accessToken;
                    return redirect('/admin/dashboard')->with(['token' => $token]);
                }
                else if ($user->isRole() === "Автор") {
                    $token = $user->createToken('AppName')->accessToken;
                    return redirect('/my-works')->with(['token' => $token]);
                }
                else if ($user->isRole() === "Эксперт") {
                    $token = $user->createToken('AppName')->accessToken;
                    return redirect('/e-show-works')->with(['token' => $token]);
                }
                else if ($user->isRole() === "Председатель") {
                    $token = $user->createToken('AppName')->accessToken;
                    return redirect('/show-works')->with(['token' => $token]);
                }
                else if ($user->isRole() === "Секретарь") {
                    $token = $user->createToken('AppName')->accessToken;
                    return redirect('/show-works')->with(['token' => $token]);
                }
                else {
                    return redirect()->back();
                }
            }
        } else {
            return redirect()->back()->with([
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
