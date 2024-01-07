<?php

namespace App\Http\Controllers;

use App\Models\SubjectArea;
use App\Models\Work;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function showForm() {
        $subjectAreas = SubjectArea::all();
        return view('autors/autors_download_layout', ["title" => "Загрузка работы", "message" => "Пожалуйста, заполните все поля и загрузите все файлы", "subjectAreas" => $subjectAreas]);
    }

    public function processForm(Request $request) {
        // // Проверка наличия данных в полях формы
        // $data = $request->validate([
        //     'field1' => 'required',
        //     'field2' => 'required',
        //     // Добавьте другие поля по необходимости
        // ]);

        // Если поля не пустые, переход на другую страницу
        //$worksDB = DB::select('select * from works');
        $worksDB = Work::all();
        // dd($worksDB + [[1],[2],[3]]);
        return redirect()->route('myWorksTest1', ["worksDB" => $worksDB]); //"url" => "/myWorksTest1", "method" => "post",
    }
}
