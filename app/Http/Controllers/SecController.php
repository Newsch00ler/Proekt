<?php

namespace App\Http\Controllers;

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
        return view('sec/sec_add_date_layout', ["title" => "Выбор даты"]);
    }

    public function verWorks() {
        return view('sec/sec_work_verification_layout', ["title" => "Подтверждение работ"]);
    }

    public function saveDate(Request $request) {
        $dateString = $request->input('calendar');
        $date = new DateTime($dateString);
        $formattedDate = $date->format('Y-m-d');
        $currentDate = new DateTime();
        $currentDateFormatted = $currentDate->format('Y-m-d');
        if ($date < $currentDate) {
            $str = implode(" ", [$formattedDate, $currentDateFormatted]);
        }
        else {
            $str = implode(" ", [$currentDateFormatted, $formattedDate]);
        }
        $filePath = storage_path('date.txt');
        file_put_contents($filePath, $str);
        return redirect()->route('show.works');
    }
}
