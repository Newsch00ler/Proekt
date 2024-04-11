<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExpertController extends Controller
{
    public function showWorks(){
        return view('experts/experts_works_layout', ["title" => "Работы"]);
    }

    public function checkWork(){
        return view('experts/experts_scoring_layout', ["title" => "Оценка работы"]);
    }
}
