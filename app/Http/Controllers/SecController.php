<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use DateTime;

class SecController extends Controller
{
    public function showWorks(){
        return view('chm_sec/chm_sec_works_layout', ["title" => "Работы"]);
    }

    public function showExperts(){
        return view('chm_sec/chm_sec_experts_layout', ["title" => "Эксперты"]);
    }

    public function addDate() {
        $filePath = storage_path('date.txt');
        if(File::size($filePath) !== 0){
            $date = File::exists($filePath) ? File::get($filePath) : date('d.m.Y');
            $date = new DateTime($date);
            $dateFormatted = $date->format('Y-m-d');
            $textButton = "Изменить";
        }
        else {
            $dateFormatted = '';
            $textButton = "Подтвердить";
        }
        return view('sec/sec_add_date_layout', ["title" => "Выбор даты", "dateFormatted" => $dateFormatted, "textButton" => $textButton]);
    }

    public function saveDate(Request $request) {
        $dateString = $request->input('calendar');
        $date = new DateTime($dateString);
        $formattedDate = $date->format('d.m.Y');
        $str = implode(" ", [$formattedDate]);
        $filePath = storage_path('date.txt');
        file_put_contents($filePath, $str);
        return redirect()->back();
    }

    public function valWorks(Request $request) {
        $worksDB = DB::select('select * from val_works where validation = false');
        return view('sec/sec_work_validation_layout', ["title" => "Подтверждение работ", "worksDB" => $worksDB]);
    }

    public function saveVal(Request $request) {
        $workIds = $request->input('work_ids', []);
        if (!empty($workIds)) {
            DB::table('works')->whereIn('id_work', $workIds)->update(['validation' => true]);
        }
        return redirect()->back();
    }
}
