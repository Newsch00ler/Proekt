<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ExpertController extends Controller
{
    public function showWorks(){
        $expertSubjectAreas = DB::select('select subject_areas.name_subject_area as name_subject_area
        from subject_areas
        inner join users_subject_areas on subject_areas.id_subject_area = users_subject_areas.id_subject_area
        inner join users on users_subject_areas.id_user  = users.id_user
        where users.id_user = ?', [Auth::user()->id_user]);
        $expertSubjectAreas = array_column($expertSubjectAreas, 'name_subject_area'); // предметные области эксперта
        $worksSubjectAreas = []; // работы по предметным областям эксперта
        foreach ($expertSubjectAreas as $expertSubjectArea) {
            $worksForSubjectArea = DB::select('select works.name_work,
                STRING_AGG(DISTINCT subject_areas.name_subject_area, \', \') as name_subject_area,
                works.original_percent as original_percent,
                works.created_at as created_at,
                SPLIT_PART(link_pdf_file, \'\\\', -1) as file_name,
                works.status as status
            from works
            inner join works_subject_areas on works.id_work = works_subject_areas.id_work
            inner join subject_areas on works_subject_areas.id_subject_area = subject_areas.id_subject_area
            where works.status != \'Не подтверждена\' and works.id_work IN (
                SELECT works_subject_areas.id_work
                from works_subject_areas
                inner join subject_areas on works_subject_areas.id_subject_area = subject_areas.id_subject_area
                where subject_areas.name_subject_area = ?
            )
            group by works.name_work, works.original_percent, works.created_at, works.link_pdf_file, works.status', [$expertSubjectArea]);
            $worksSubjectAreas = array_merge($worksSubjectAreas, $worksForSubjectArea); // добавление всех работ по предметным областям эксперта
        }
        $worksForCheck = array_unique($worksSubjectAreas, SORT_REGULAR);  // оставить только единожды поввторяющиеся работы
        // $countAllWorks = count($worksSubjectAreas);
        // $countAllVerifiedWorks = array_filter($worksSubjectAreas, function($work) {
        //     return $work->status === 'Внесена в протокол';
        // });
        // $countAllVerifiedWorks = array_values($countAllVerifiedWorks);
        $role = Auth::user()->role;
        if ($role === 'Председатель' || $role === 'Секретарь'){
            $url = url('/show-works');
        }
        else if ($role === 'Эксперт'){
            $url = url('/e-show-works');
        }
        return view('experts/experts_works_layout', ["title" => "Работы для оценивания", "message1" => "Тут надо менять всё", "link" => "/loadPdfFiles/Varianty_k_PR_5.pdf", "worksForCheck" => $worksForCheck, 'url' => $url, 'role' => $role]);
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
