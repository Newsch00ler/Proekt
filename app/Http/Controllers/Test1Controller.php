<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Work;
use Illuminate\Http\Request;

class Test1Controller extends Controller
{
    public function showSuccessPage() {
        // Логика обработки данных и отображения успешной страницы
        $worksDB = DB::select('select * from works');
        //$worksDB = Work::all();
        return view('autors/autors_works_layout', ["title" => "Мои работы", "message" => "", "worksDB" => $worksDB]); //"url" => "/myWorksTest", "method" => "get",
    }
}
