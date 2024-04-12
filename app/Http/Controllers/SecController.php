<?php

namespace App\Http\Controllers;

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

    public function verWorks() {
        return view('sec/sec_work_verification_layout', ["title" => "Подтверждение работ"]);
    }

    public function saveDate(Request $request) {
        $dateString = $request->input('calendar');
        $date = new DateTime($dateString);
        $formattedDate = $date->format('d.m.Y');
        // $currentDate = new DateTime();
        // $currentDateFormatted = $currentDate->format('d.m.Y');
        $str = implode(" ", [$formattedDate]);
        $filePath = storage_path('date.txt');
        file_put_contents($filePath, $str);
        return redirect()->back();
    }
}
