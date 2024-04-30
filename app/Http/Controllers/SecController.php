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
        $worksDB = DB::select('select * from all_works');
        $countAllWorks = DB::select('select COUNT(*) from works');
        $countAllVerifiedWorks = DB::select('select COUNT(*) from works where status = \'Внесена в протокол\'');
        $countAllUnverifiedWorks = DB::select('select COUNT(*) from works where status = \'Не подтверждена\' or status = \'На проверке\'');
        $role = Auth::user()->role;
        $url = url('/show-works');
        // dd($worksDB);
        return view('chm_sec/chm_sec_works_layout', ["title" => "Работы", "message1" => "Тут работы", "message2" => "Тут оценки","link" => "/loadPdfFiles/Varianty_k_PR_5.pdf", "worksDB" => $worksDB, "countAllWorks" => $countAllWorks[0]->count, "countAllVerifiedWorks" => $countAllVerifiedWorks[0]->count, "countAllUnverifiedWorks" => $countAllUnverifiedWorks[0]->count, 'url' => $url, 'role' => $role]);
    }

    public function showExperts(){
        $expertsDB = DB::select('select users.full_name,
            STRING_AGG(subject_areas.name_subject_area, \', \') as name_subject_area
        from users
        inner join users_subject_areas on users.id_user = users_subject_areas.id_user
        inner join subject_areas on users_subject_areas.id_subject_area  = subject_areas.id_subject_area
        where users.role != \'Автор\' and users.role != \'Администратор\'
        group by users.id_user');
        $role = Auth::user()->role;
        $url = url('/show-works');
        return view('chm_sec/chm_sec_experts_layout', ["title" => "Эксперты", 'expertsDB' => $expertsDB, 'url' => $url, 'role' => $role]);
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
            foreach ($workIds as $workId) {
                $workSubjectAreas = DB::select('select
                    STRING_AGG(subject_areas.name_subject_area, \', \') as name_subject_area
                from works
                left join works_subject_areas ON works.id_work = works_subject_areas.id_work
                left join subject_areas ON works_subject_areas.id_subject_area = subject_areas.id_subject_area
                where works.id_work = ?', [$workId]);
                dd($workSubjectAreas[0]->name_subject_area);
                // продолжить делать добавление работ на проверку к экспертам после подтверждения
                DB::table('works')->whereIn('id_work', $workIds)->update(['status' => 'На проверке']);
            }
        }
        return redirect()->back();
    }
}
