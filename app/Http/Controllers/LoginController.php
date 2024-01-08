<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showPageLogin() {
        return view('login_layout', ["title" => "Авторизация"]);
    }
}
