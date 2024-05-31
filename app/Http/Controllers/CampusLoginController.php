<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CampusLoginController extends Controller
{
    public function campusAuth(Request $request) {
        try {
            return redirect()->away('https://int.istu.edu/oauth/authorize/?client_id=local.663a4c4fa5f519.53589057');
        } catch(\Exception $exception) {
            return redirect()->back()->with(["error" => "Произошла ошибка, попробуйте позже"]);
        }
    }

    public function bitrixAuth(Request $request) {
        try {
            // тут сделать обработку входа + добавление записей пользователей в нашу БД
            $scriptPath = public_path('scripts/AuthCampus.py'); // питон файл для входа через кампус
            $command = "python3 $scriptPath 2>&1";
            exec($command);
            // return redirect()->away('https://int.istu.edu/oauth/authorize/?client_id=local.663a4c4fa5f519.53589057');
        } catch(\Exception $exception) {
            return redirect()->back()->with(["error" => "Произошла ошибка, попробуйте позже"]);
        }
    }
}
