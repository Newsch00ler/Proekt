<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\User;
use DateTime;

class LoginController extends Controller
{
    public function showPageLogin() {
        try {
            $maxIdProtocol = DB::select('select max(id_protocol) from protocols');
            if($maxIdProtocol[0]->max !== null) {
                $date = DB::select('select meeting_date from protocols where id_protocol = ?', [$maxIdProtocol[0]->max]);
                $date = new DateTime($date[0]->meeting_date);
                $currentDate = new DateTime();
                if ($date->format('d.m.Y') === $currentDate->format('d.m.Y')) {
                    $statusMaxIdProtocol = DB::select('select status from protocols where id_protocol = ?', [$maxIdProtocol[0]->max]);
                    if ($statusMaxIdProtocol[0]->status === 'Создан') {
                        DB::update('update protocols set status = \'К утверждению\' where id_protocol = ?', [$maxIdProtocol[0]->max]);
                    }
                }
            }
            return view('login_layout', ["title" => "Авторизация", "message" => "Введите данные для входа"]);
        } catch (\Exception $exception) {
            error_log("Ошибка выполнения запроса в БД: {$exception->getMessage()}\n");
            return redirect()->back()->with(["error" => "Произошла ошибка, попробуйте позже"]);
        }
    }

    public function login(Request $request) {
        try {
            $credentials = $request->validate([
                'login' => ['required', 'string'],
                'password' => ['required'],
            ]);
            $user = User::where('login', $credentials['login'])->first();
            if ($user && password_verify($credentials['password'], $user->password)) {
                if (Auth::attempt(['login' => $credentials['login'], 'password' => $credentials['password']])) {
                    $request->session()->regenerate();

                    $redirectUrl = '';

                    switch ($user->isRole()) {
                        case "Администратор":
                            $redirectUrl = '/admin/dashboard';
                            break;
                        case "Автор":
                            $redirectUrl = '/my-works';
                            break;
                        case "Эксперт":
                            $redirectUrl = '/e-show-works';
                            break;
                        case "Председатель":
                        case "Секретарь":
                            $redirectUrl = '/show-works';
                            break;
                        default:
                            return redirect()->back()->with(["error" => "Произошла ошибка, попробуйте позже"]);
                    }
                    $token = $user->createToken('AppName')->accessToken;
                    return redirect($redirectUrl)->with(['token' => $token]);
                }
            } else {
                return redirect()->back()->with(["error" => "Неправильный логин или пароль"]);
            }
        } catch (\Exception $exception) {
            error_log("Ошибка выполнения запроса в БД: {$exception->getMessage()}\n");
            return redirect()->back()->with(["error" => "Произошла ошибка, попробуйте позже"]);
        }
    }

    public function logout(Request $request) : RedirectResponse {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
