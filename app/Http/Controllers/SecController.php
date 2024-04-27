<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DateTime;

class SecController extends Controller
{
    public function showWorks(){
        $worksDB = DB::select('select * from my_works');
        $countAllWorks = DB::select('select COUNT(*) from works');
        $countAllVerifiedWorks = DB::select('select COUNT(*) from works where status = \'Внесена в протокол\'');
        $countAllUnverifiedWorks = DB::select('select COUNT(*) from works where status = \'Не подтверждена\' or status = \'На проверке\'');
        $role = Auth::user()->role;
        $url = url('/show-works');
        return view('chm_sec/chm_sec_works_layout', ["title" => "Работы", "message1" => "Тут работы", "message2" => "Тут оценки","link" => "/loadPdfFiles/Varianty_k_PR_5.pdf", "worksDB" => $worksDB, "countAllWorks" => $countAllWorks[0]->count, "countAllVerifiedWorks" => $countAllVerifiedWorks[0]->count, "countAllUnverifiedWorks" => $countAllUnverifiedWorks[0]->count, 'url' => $url, 'role' => $role]);
    }

    public function showExperts(){
        $role = Auth::user()->role;
        $url = url('/show-works');
        return view('chm_sec/chm_sec_experts_layout', ["title" => "Эксперты", 'url' => $url, 'role' => $role]);
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
        $role = Auth::user()->role;
        $url = url('/show-works');
        return view('sec/sec_add_date_layout', ["title" => "Выбор даты", "dateFormatted" => $dateFormatted, "textButton" => $textButton, 'url' => $url, 'role' => $role]);
    }

    public function saveDate(Request $request) {
        $dateString = $request->input('calendar');
        $date = new DateTime($dateString);
        $formattedDate = $date->format('d.m.Y');
        $str = implode(" ", [$formattedDate]);
        $filePath = storage_path('date.txt');
        $currentDate = new DateTime();
        $formattedCurrentDate = $currentDate->format('d.m.Y');
        if ($formattedCurrentDate !== $formattedDate) {
            file_put_contents($filePath, $str);
        }
        else {
            file_put_contents($filePath, '');
        }
        return redirect()->back();
    }

    public function valWorks(Request $request) {
        $worksDB = DB::select('select * from val_works where status = \'Не подтверждена\'');
        $role = Auth::user()->role;
        $url = url('/show-works');
        return view('sec/sec_work_validation_layout', ["title" => "Подтверждение работ", "worksDB" => $worksDB, 'url' => $url, 'role' => $role]);
    }

    public function saveVal(Request $request) {
        $workIds = $request->input('work_ids', []);
        if (!empty($workIds)) {
            DB::table('works')->whereIn('id_work', $workIds)->update(['status' => 'На проверке']);
        }
        return redirect()->back();
    }
}
