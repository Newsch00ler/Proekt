<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ExpertController extends Controller
{
    public function showWorks(){
        try {
            $id_user = Auth::user()->id_user;
            $expertSubjectAreas = DB::select('select subject_areas.name_subject_area as name_subject_area
            from subject_areas
            inner join users_subject_areas on subject_areas.id_subject_area = users_subject_areas.id_subject_area
            inner join users on users_subject_areas.id_user  = users.id_user
            where users.id_user = ?', [Auth::user()->id_user]);
            $expertSubjectAreas = array_column($expertSubjectAreas, 'name_subject_area'); // предметные области эксперта
            $worksSubjectAreas = []; // работы по предметным областям эксперта
            foreach ($expertSubjectAreas as $expertSubjectArea) {
                $worksForSubjectArea = DB::select('select works.id_work,
                    works.name_work,
                    STRING_AGG(DISTINCT subject_areas.name_subject_area, \', \') as name_subject_area,
                    works.original_percent as original_percent,
                    works.created_at as created_at,
                    regexp_replace(works.link_pdf_file, \'^.*\\/\', \'\') AS file_name,
                    works.status as status,
                    regexp_replace(works.link_text_percent1, \'^.*\\/\', \'\') AS file_text_percent1,
                    regexp_replace(works.link_text_percent2, \'^.*\\/\', \'\') AS file_text_percent2,
                    regexp_replace(works.link_text_percent3, \'^.*\\/\', \'\') AS file_text_percent3,
                    regexp_replace(works.link_text_percent4, \'^.*\\/\', \'\') AS file_text_percent4,
                    regexp_replace(works.link_text_percent5, \'^.*\\/\', \'\') AS file_text_percent5,
                    works.percent1 as percent1,
                    works.percent2 as percent2,
                    works.percent3 as percent3,
                    works.percent4 as percent4,
                    works.percent5 as percent5
                from works
                inner join works_subject_areas on works.id_work = works_subject_areas.id_work
                inner join subject_areas on works_subject_areas.id_subject_area = subject_areas.id_subject_area
                inner join experts_works on works.id_work = experts_works.id_work
                inner join users on experts_works.id_user = users.id_user
                where experts_works.criterion1 is null and
                experts_works.criterion2 is null and
                experts_works.criterion3 is null and
                experts_works.criterion4 is null and
                experts_works.criterion5 is null and
                works.status = \'На проверке\' and works.id_work IN (
                    SELECT works_subject_areas.id_work
                    from works_subject_areas
                    inner join subject_areas on works_subject_areas.id_subject_area = subject_areas.id_subject_area
                    where subject_areas.name_subject_area = ?
                ) and experts_works.id_user = ?
                group by works.id_work', [$expertSubjectArea, $id_user]);
                $worksSubjectAreas = array_merge($worksSubjectAreas, $worksForSubjectArea); // добавление всех работ по предметным областям эксперта
            }

            $worksForCheck = array_unique($worksSubjectAreas, SORT_REGULAR);  // оставить только единожды поввторяющиеся работы
            $message1 = [];
            foreach ($worksForCheck as $work) {
                $message = [];
                foreach ($work as $index => $value) {
                    if (strpos($index, 'file_text_percent') === 0 || strpos($index, 'percent') === 0) {
                        if ($value !== null) {
                            $message[] = $value;
                        }
                    }
                }
                if (!empty($message)) {
                    $message1[] = array_combine(range(1, count($message)), array_values($message));
                }
            }

            $full_name = Auth::user()->full_name;
            $role = Auth::user()->role;
            if ($role === 'Председатель' || $role === 'Секретарь'){
                $url = url('/show-works');
            }
            else if ($role === 'Эксперт'){
                $url = url('/e-show-works');
            }

            $viewRole = 'Эксперт';

            $protocolWorks = DB::select('select * from protocol_works');
            $scriptPath = public_path('scripts/CreateProtocol.py');
            $jsonWorksDB = json_encode($protocolWorks, JSON_UNESCAPED_UNICODE);
            $encodedJsonWorksDB = base64_encode($jsonWorksDB);
            $command = "python3 $scriptPath $encodedJsonWorksDB 2>&1";
            exec($command);
            return view('experts/experts_works_layout', ["title" => "Работы для оценивания", "message1" => $message1, "worksForCheck" => $worksForCheck, 'url' => $url, 'full_name' => $full_name, 'role' => $role, 'viewRole' => $viewRole]);
        } catch (\Exception $exception) {
            error_log("{$exception->getMessage()}\n");
            return redirect()->back()->with(["error" => "Произошла ошибка, попробуйте позже"]);
        }
    }

    public function checkWork(Request $request){
        try {
            $id_user = Auth::user()->id_user;
            $full_name = Auth::user()->full_name;
            $role = Auth::user()->role;
            if ($role === 'Председатель' || $role === 'Секретарь'){
                $url = url('/show-works');
            }
            else if ($role === 'Эксперт'){
                $url = url('/e-show-works');
            }
            $viewRole = 'Эксперт';
            $id_work = $request->query('id');
            $work = DB::select('select * from works where id_work = ?', [$id_work]);
            $workForCheck = DB::select('select experts_works.id_user as id_user,
                experts_works.id_work as id_work,
                experts_works.criterion1 as criterion1,
                experts_works.criterion2 as criterion2,
                experts_works.criterion3 as criterion3,
                experts_works.criterion4 as criterion4,
                experts_works.criterion5 as criterion5,
                works.name_work as name_work,
                works.original_percent as original_percent,
                regexp_replace(works.link_pdf_file, \'^.*\\/\', \'\') AS file_name,
                regexp_replace(works.link_text_percent1, \'^.*\\/\', \'\') AS file_text_percent1,
                regexp_replace(works.link_text_percent2, \'^.*\\/\', \'\') AS file_text_percent2,
                regexp_replace(works.link_text_percent3, \'^.*\\/\', \'\') AS file_text_percent3,
                regexp_replace(works.link_text_percent4, \'^.*\\/\', \'\') AS file_text_percent4,
                regexp_replace(works.link_text_percent5, \'^.*\\/\', \'\') AS file_text_percent5,
                works.percent1 as percent1,
                works.percent2 as percent2,
                works.percent3 as percent3,
                works.percent4 as percent4,
                works.percent5 as percent5
            from experts_works
            inner join works on experts_works.id_work = works.id_work
            where experts_works.id_user = ? and experts_works.id_work = ?', [$id_user, $id_work]);
            $message1 = [];
            foreach ($workForCheck as $work) {
                $message = [];
                foreach ($work as $index => $value) {
                    if (strpos($index, 'file_text_percent') === 0 || strpos($index, 'percent') === 0) {
                        if ($value !== null) {
                            $message[] = $value;
                        }
                    }
                }
                if (!empty($message)) {
                    $message1[] = array_combine(range(1, count($message)), array_values($message));
                }
            }
            return view('experts/experts_scoring_layout', ["title" => "Оценка работы", "message" => "Пожалуйста, оцените все критерии", "message1" => $message1[0], "work" => $workForCheck[0], 'url' => $url, 'full_name' => $full_name, 'role' => $role, 'viewRole' => $viewRole]);
        } catch (\Exception $exception) {
            error_log("{$exception->getMessage()}\n");
            return redirect()->back()->with(["error" => "Произошла ошибка, попробуйте позже"]);
        }
    }

    public function saveCheckWork(Request $request) {
        try {
            $id_user = Auth::user()->id_user;
            $workId = $request->input('id_work');
            $criterion1 = $request->input('selectRelevance');
            $criterion2 = $request->input('selectCompleteness');
            $criterion3 = $request->input('selectDepth');
            $criterion4 = $request->input('selectQuestions');
            $criterion5 = $request->input('selectQuality');
            DB::update('update experts_works set criterion1 = ?,
            criterion2 = ?,
            criterion3 = ?,
            criterion4 = ?,
            criterion5 = ?
            where id_user = ? and id_work = ?', [$criterion1, $criterion2, $criterion3, $criterion4, $criterion5, $id_user, $workId]);
            $counts = DB::select('select count(*) as all,
                (select count(*)
                from experts_works
                where criterion1 is not null and
                criterion2 is not null and
                criterion3 is not null and
                criterion4 is not null and
                criterion5 is not null and
                id_work = ?) as all_check
            from experts_works
            where id_work = ?', [$workId, $workId]);
            if ($counts[0]->all === $counts[0]->all_check) {
                $grades = DB::select('select criterion1 + criterion2 + criterion3 + criterion4 + criterion5 as grade
                from experts_works
                where id_work = ?', [$workId]);
                $final_grade = 0;
                foreach ($grades as $grade) {
                    $final_grade = $final_grade + $grade->grade;
                }
                $type_work = DB::select('select type from works where id_work = ?', [$workId]);
                $language_work = DB::select('select language from works where id_work = ?', [$workId]);
                if ($type_work[0]->type === "Учебник с грифом"){
                    $k = 60;
                }
                else if ($type_work[0]->type === "Учебное пособие с грифом"){
                    $k = 40;
                }
                else if ($type_work[0]->type === "Учебное пособие"){
                    if ($language_work[0]->language === "Foreign"){
                        $k = 40;
                    }
                    else {
                        $k = 30;
                    }
                }
                else if ($type_work[0]->type === "Сборник задач" || $type_work[0]->type === "Практикум / лабораторный практикум"){
                    if ($language_work[0]->language === "Foreign"){
                        $k = 30;
                    }
                    else {
                        $k = 25;
                    }
                }
                else{
                    $k = 1;
                }
                $final_grade = $k * ($final_grade / (count($grades) * 50));
                $maxIdProtocol = DB::select('select max(id_protocol) from protocols where status = \'Создан\'');
                if ($maxIdProtocol[0]->max === null) {
                    DB::update('update works set status = \'Проверена\', final_grade = ? where id_work = ?', [$final_grade, $workId]);
                }
                else {
                    DB::update('update works set status = \'Внесена в протокол\', final_grade = ?, id_protocol = ? where id_work = ?', [$final_grade, $maxIdProtocol[0]->max, $workId]);
                    try{
                        $protocolWorks = DB::select('select * from protocol_works');
                        $scriptPath = public_path('scripts/CreateProtocol.py');
                        $jsonWorksDB = json_encode($protocolWorks, JSON_UNESCAPED_UNICODE);
                        $encodedJsonWorksDB = base64_encode($jsonWorksDB);
                        $command = "python3 $scriptPath $encodedJsonWorksDB 2>&1";
                        exec($command);
                    } catch (\Exception $exception) {
                        error_log("{$exception->getMessage()}\n");
                        DB::update('update experts_works set criterion1 = ?,
                        criterion2 = ?,
                        criterion3 = ?,
                        criterion4 = ?,
                        criterion5 = ?
                        where id_user = ? and id_work = ?', [null, null, null, null, null, Auth::user()->id_user, $request->input('id_work')]);
                        DB::update('update works set status = \'На проверке\', final_grade = ?, id_protocol = ? where id_work = ?', [null, null, $request->input('id_work')]);
                        return redirect()->back()->with(["error" => "Произошла ошибка, попробуйте позже"]);
                    }
                }
            }
            return redirect()->route('e.show.works');
        } catch (\Exception $exception) {
            error_log("{$exception->getMessage()}\n");
            DB::update('update experts_works set criterion1 = ?,
            criterion2 = ?,
            criterion3 = ?,
            criterion4 = ?,
            criterion5 = ?
            where id_user = ? and id_work = ?', [null, null, null, null, null, Auth::user()->id_user, $request->input('id_work')]);
            DB::update('update works set status = \'На проверке\', final_grade = ?, id_protocol = ? where id_work = ?', [null, null, $request->input('id_work')]);
            return redirect()->back()->with(["error" => "Произошла ошибка, попробуйте позже"]);
        }
    }
}
