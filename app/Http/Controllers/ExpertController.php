<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ExpertController extends Controller
{
    public function showWorks(){
        $worksDB = DB::select('select * from my_works');
        $countAllWorks = DB::select('select COUNT(*) from works');
        $countAllVerifiedWorks = DB::select('select COUNT(*) from works where status = \'Внесена в протокол\'');
        $countAllUnverifiedWorks = DB::select('select COUNT(*) from works where status = \'Не подтверждена\' or status = \'На проверке\'');
        $role = Auth::user()->role;
        if ($role === 'Председатель' || $role === 'Секретарь'){
            $url = url('/show-works');
        }
        else if ($role === 'Эксперт'){
            $url = url('/e-show-works');
        }
        return view('experts/experts_works_layout', ["title" => "Работы для оценивания", "message1" => "Тут надо менять всё", "link" => "/loadPdfFiles/Varianty_k_PR_5.pdf", "worksDB" => $worksDB, "countAllWorks" => $countAllWorks[0]->count, "countAllVerifiedWorks" => $countAllVerifiedWorks[0]->count, "countAllUnverifiedWorks" => $countAllUnverifiedWorks[0]->count, 'url' => $url, 'role' => $role]);
    }

    public function checkWork(){
        $role = Auth::user()->role;
        if ($role === 'Председатель' || $role === 'Секретарь'){
            $url = url('/show-works');
        }
        else if ($role === 'Эксперт'){
            $url = url('/e-show-works');
        }
        return view('experts/experts_scoring_layout', ["title" => "Оценка работы/id", "message1" => "Тут надо менять всё", "link" => "/loadPdfFiles/Varianty_k_PR_5.pdf", 'url' => $url, 'role' => $role]);
    }
}
