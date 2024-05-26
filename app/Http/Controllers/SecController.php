<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use DateTime;

class SecController extends Controller
{
    public function showWorks(){
         try {
            $worksDB = DB::select('select all_works.* from all_works
            left join protocols on all_works.id_protocol = protocols.id_protocol
            where (case
                when ((select count(*) from protocols) = 0) then true
                when ((select count(*) from protocols) = 1) then
                    case
                        when ((select status from protocols) != \'Утвержден\') then true
                        else
                            case
                                when all_works.status != \'Внесена в протокол\' then true
                                else false
                            end
                    end
                else
                    case
                        when all_works.id_protocol is null or (protocols.id_protocol is not null and protocols.status in (\'Создан\', \'К утверждению\')) then true
                        else false
                    end
            end)
            order by all_works.created_at asc');
            $countAllVerifiedWorks = array_filter($worksDB, function($work) {
                return ($work->status === 'Внесена в протокол' || $work->status === 'Проверена');
            });
            $countAllUnverifiedWorks = array_filter($worksDB, function($work) {
                return $work->status === 'На проверке';
            });
            $countAllRejectedWorks = array_filter($worksDB, function($work) {
                return $work->status === 'Отклонена';
            });
            $countAllWorks = count($worksDB);
            $countAllVerifiedWorks = count($countAllVerifiedWorks);
            $countAllUnverifiedWorks = count($countAllUnverifiedWorks);
            $countAllRejectedWorks = count($countAllRejectedWorks);
            $message1 = [];
            foreach ($worksDB as $work) {
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
            $grades = [];
            $message2 = [];
            foreach ($worksDB as $work) {
                $grades[] = DB::select('select
                    experts_works.id_work as id_work,
                    users.full_name as full_name,
                    criterion1 + criterion2 + criterion3 + criterion4 + criterion5 as grades
                from experts_works
                inner join works on experts_works.id_work = works.id_work
                inner join users on experts_works.id_user = users.id_user
                where (works.status = \'Проверена\' or works.status = \'Внесена в протокол\') and works.id_work = ?', [$work->id_work]);
            }
            foreach ($grades as $grade) {
                $message = '';
                foreach ($grade as $index => $gr) {
                    if ($index === 0) {
                        $message .= $gr->full_name . ': ' . $gr->grades . ' баллов' . '\n';
                    }
                    else {
                        $message .= '\n' . $gr->full_name . ': ' . $gr->grades . ' баллов' . '\n';
                    }
                }
                $message2[] = $message;
            }
            $full_name = Auth::user()->full_name;
            $role = Auth::user()->role;
            if ($role === 'Председатель') {
                $viewRole = 'Председатель';
            }
            else {
                $viewRole = 'Секретарь';
            }
            $url = url('/show-works');
            return view('chm_sec/chm_sec_works_layout', ["title" => "Работы", "message1" => $message1, "message2" => $message2, "link" => "/loadPdfFiles/Varianty_k_PR_5.pdf", "worksDB" => $worksDB, "countAllWorks" => $countAllWorks, "countAllVerifiedWorks" => $countAllVerifiedWorks, "countAllUnverifiedWorks" => $countAllUnverifiedWorks, "countAllRejectedWorks" => $countAllRejectedWorks, 'url' => $url, 'full_name' => $full_name, 'role' => $role, 'viewRole' => $viewRole]);
        } catch (\Exception $exception) {
            error_log("{$exception->getMessage()}\n");
            return redirect()->back()->with(["error" => "Произошла ошибка, попробуйте позже"]);
        }
    }

    public function showExperts(){
        try {
            $expertsDB = DB::select('select users.full_name,
                string_agg(distinct subject_areas.name_subject_area, \', \') as name_subject_area,
                concat(
                    (select count(*)
                    from experts_works
                    left join works on experts_works.id_work = works.id_work
                    left join protocols on works.id_protocol = protocols.id_protocol
                    where id_user = users.id_user and experts_works.criterion1 is not null and
                    experts_works.criterion2 is not null and
                    experts_works.criterion3 is not null and
                    experts_works.criterion4 is not null and
                    experts_works.criterion5 is not null
                    and
                    (case
                        when ((select count(*) from protocols) = 0) then true
                        when ((select count(*) from protocols) = 1) then
                            case
                                when ((select status from protocols) != \'Утвержден\') then true
                                else
                                    case
                                        when works.status != \'Внесена в протокол\' then true
                                        else false
                                    end
                            end
                        else
                            case
                                when works.id_protocol is null or (protocols.id_protocol is not null and protocols.status in (\'Создан\', \'К утверждению\')) then true
                                else false
                            end
                    end)
                    ),
                    \'/\',
                    (select count(*)
                    from experts_works
                    left join works on experts_works.id_work = works.id_work
                    left join protocols on works.id_protocol = protocols.id_protocol
                    where id_user = users.id_user
                    and
                    (case
                        when ((select count(*) from protocols) = 0) then true
                        when ((select count(*) from protocols) = 1) then
                            case
                                when ((select status from protocols) != \'Утвержден\') then true
                                else
                                    case
                                        when works.status != \'Внесена в протокол\' then true
                                        else false
                                    end
                            end
                        else
                            case
                                when works.id_protocol is null or (protocols.id_protocol is not null and protocols.status in (\'Создан\', \'К утверждению\')) then true
                                else false
                            end
                    end)
                    )
                ) as checked_works
            from users
            left join users_subject_areas on users.id_user = users_subject_areas.id_user
            left join subject_areas on users_subject_areas.id_subject_area  = subject_areas.id_subject_area
            left join experts_works ON users.id_user = experts_works.id_user
            where users.role != \'Автор\' and users.role != \'Администратор\'
            group by users.id_user');
            $full_name = Auth::user()->full_name;
            $role = Auth::user()->role;
            if ($role === 'Председатель') {
                $viewRole = 'Председатель';
            }
            else {
                $viewRole = 'Секретарь';
            }
            $url = url('/show-works');
            return view('chm_sec/chm_sec_experts_layout', ["title" => "Эксперты", 'expertsDB' => $expertsDB, 'url' => $url, 'full_name' => $full_name, 'role' => $role, 'viewRole' => $viewRole]);
        } catch (\Exception $exception) {
            error_log("{$exception->getMessage()}\n");
            return redirect()->back()->with(["error" => "Произошла ошибка, попробуйте позже"]);
        }
    }

    public function meeting() {
        try {
            $maxIdProtocol = DB::select('select max(id_protocol) from protocols');
            $textButton = "";
            if ($maxIdProtocol[0]->max === null) {
                $dateFormatted = '';
                $textButton = "Подтвердить";
                $isVisible1 = true;
                $isVisible2 = false;
            }
            else {
                $protocol = DB::select('select meeting_date, status from protocols where id_protocol = ?', [$maxIdProtocol[0]->max]);
                $date = new DateTime($protocol[0]->meeting_date);
                $dateFormatted = $date->format('Y-m-d');
                $currentDate = new DateTime();
                if ($protocol[0]->status === 'Утвержден') {
                    $dateFormatted = '';
                    $textButton = "Подтвердить";
                    $isVisible1 = true;
                    $isVisible2 = false;
                }
                elseif ($dateFormatted > $currentDate->format('Y-m-d')) {
                    $isVisible1 = true;
                    $isVisible2 = false;
                    $textButton = "Изменить";
                }
                elseif ($dateFormatted <= $currentDate->format('Y-m-d')) {
                    $isVisible1 = false;
                    $isVisible2 = true;
                }
            }
            $full_name = Auth::user()->full_name;
            $role = Auth::user()->role;
            $url = url('/show-works');
            return view('sec/sec_meeting_layout', ["title" => "Заседание и протокол", "dateFormatted" => $dateFormatted, "textButton" => $textButton, 'isVisible1' => $isVisible1, 'isVisible2' => $isVisible2, 'url' => $url, 'full_name' => $full_name, 'role' => $role, 'viewRole' => $role]);
        } catch (\Exception $exception) {
            error_log("{$exception->getMessage()}\n");
            return redirect()->back()->with(["error" => "Произошла ошибка, попробуйте позже"]);
        }
    }

    public function saveDate(Request $request) {
        try {
            $maxIdProtocol = DB::select('select max(id_protocol) from protocols');
            $dateString = $request->input('calendar');
            $date = new DateTime($dateString);
            if($maxIdProtocol[0]->max === null) {
                DB::insert('insert into protocols (meeting_date, status) values(?, \'Создан\')', [$date]);
                $maxIdProtocol = DB::select('select max(id_protocol) from protocols');
                $works = DB::select('select id_work from works where final_grade is not null and id_protocol is null');
                foreach ($works as $work) {
                    DB::update('update works set status = \'Внесена в протокол\', id_protocol = ? where id_work = ?', [$maxIdProtocol[0]->max, $work->id_work]);
                }
            }
            else {
                $protocol = DB::select('select status from protocols where id_protocol = ?', [$maxIdProtocol[0]->max]);
                if ($protocol[0]->status === 'Утвержден') {
                    DB::insert('insert into protocols (meeting_date, status) values(?, \'Создан\')', [$date]);
                    $maxIdProtocol = DB::select('select max(id_protocol) from protocols');
                    $works = DB::select('select id_work from works where final_grade is not null and id_protocol is null');

                    foreach ($works as $work) {
                        DB::update('update works set status = \'Внесена в протокол\', id_protocol = ? where id_work = ?', [$maxIdProtocol[0]->max, $work->id_work]);
                    }
                }
                else {
                    DB::update('update protocols set meeting_date = ? where id_protocol = ?', [$date, $maxIdProtocol[0]->max]);
                }
            }
            $protocolWorks = DB::select('select * from protocol_works');
            $scriptPath = public_path('scripts\CreateProtocol.py');
            $jsonWorksDB = json_encode($protocolWorks, JSON_UNESCAPED_UNICODE);
            $encodedJsonWorksDB = base64_encode($jsonWorksDB);
            $command = "python $scriptPath $encodedJsonWorksDB 2>&1";
            exec($command);
            return redirect()->back();
        } catch (\Exception $exception) {
            error_log("{$exception->getMessage()}\n");
            return redirect()->back()->with(["error" => "Произошла ошибка, попробуйте позже"]);
        }
    }

    public function approveProtocol(Request $request) {
        try {
            $maxIdProtocol = DB::select('select max(id_protocol) from protocols');
            DB::update('update protocols set status = \'Утвержден\' where id_protocol = ?', [$maxIdProtocol[0]->max]);
            $file_path = public_path('protocols\\Протокол.docx');
            $file = fopen($file_path, 'w');
            return redirect()->back();
        } catch (\Exception $exception) {
            error_log("{$exception->getMessage()}\n");
            return redirect()->back()->with(["error" => "Произошла ошибка, попробуйте позже"]);
        }
    }

    public function notApproveProtocol(Request $request) {
        try {
            $maxIdProtocol = DB::select('select max(id_protocol) from protocols');
            $works = DB::select('select id_work from works where id_protocol = ?', [$maxIdProtocol[0]->max]);
            foreach ($works as $work) {
                DB::delete('delete from experts_works where id_work = ?', [$work->id_work]);
                DB::update('update works set status = \'Не подтверждена\', final_grade = null, id_protocol = null where id_work = ?', [$work->id_work]);
            }
            DB::delete('delete from protocols where id_protocol = ?', [$maxIdProtocol[0]->max]);
            $file_path = public_path('protocols\\Протокол.docx');
            $file = fopen($file_path, 'w');
            return redirect()->back();
        } catch (\Exception $exception) {
            error_log("{$exception->getMessage()}\n");
            return redirect()->back()->with(["error" => "Произошла ошибка, попробуйте позже"]);
        }
    }

    public function valWorks(Request $request) {
        try {
            $worksDB = DB::select('select * from all_works where status = \'Не подтверждена\'
            order by created_at asc');
            $message1 = [];
            foreach ($worksDB as $work) {
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
            $url = url('/show-works');
            return view('sec/sec_work_validation_layout', ["title" => "Подтверждение работ", "message1" => $message1, "worksDB" => $worksDB, 'url' => $url, 'full_name' => $full_name, 'role' => $role, 'viewRole' => $role]);
        } catch (\Exception $exception) {
            error_log("{$exception->getMessage()}\n");
            return redirect()->back()->with(["error" => "Произошла ошибка, попробуйте позже"]);
        }
    }

    public function saveVal(Request $request) {
        try {
            $radioInputs = collect($request->input())->filter(function ($value, $key) {
                return Str::startsWith($key, 'action_');
            })->toArray();
            if (!empty($radioInputs)) {
                foreach ($radioInputs as $inputName => $inputValue) {
                    $workId = substr($inputName, strlen('action_'));
                    if ($inputValue === 'approve') {
                        $workSubjectAreas = DB::select('select
                            subject_areas.name_subject_area as name_subject_area
                        from works
                        left join works_subject_areas ON works.id_work = works_subject_areas.id_work
                        left join subject_areas ON works_subject_areas.id_subject_area = subject_areas.id_subject_area
                        where works.id_work = ?', [$workId]);
                        $id_autor = DB::select('select id_user
                        from autors_works
                        where id_work = ?', [$workId]);
                        $expertsIds = [];
                        foreach ($workSubjectAreas as $workSubjectArea) {
                            $experts = DB::select('select
                                users.id_user
                            from users
                            inner join users_subject_areas on users.id_user = users_subject_areas.id_user
                            inner join subject_areas on users_subject_areas.id_subject_area  = subject_areas.id_subject_area
                            where users.id_user != ? and users."role" != \'Автор\' and users."role" != \'Администратор\' and subject_areas.name_subject_area = ?', [$id_autor[0]->id_user, $workSubjectArea->name_subject_area]);
                            foreach ($experts as $expert) {
                                $expertsIds[] = $expert->id_user;
                            }
                        }
                        $expertsIds = array_unique($expertsIds, SORT_REGULAR);
                        foreach ($expertsIds as $expertId){
                            DB::insert('insert into experts_works (id_user, id_work) values (?, ?)', [$expertId, $workId]);
                        }
                        DB::update('update works set status = \'На проверке\' where id_work = ?', [$workId]);
                    } elseif ($inputValue === 'reject') {
                        DB::update('update works set status = \'Отклонена\' where id_work = ?', [$workId]);
                    }
                }
            }
            return redirect()->back();
        } catch (\Exception $exception) {
            error_log("{$exception->getMessage()}\n");
            return redirect()->back()->with(["error" => "Произошла ошибка, попробуйте позже"]);
        }
    }
}
