<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use DateTime;

class AdminController extends Controller
{
    // вспомгательная функция изменения пароля юзеру
    // public function updateUser(Request $request) {
    //     $newPassword = bcrypt('Petrov');
    //     $updatePassword = DB::update('update users set password = ? where id_user = ?', [$newPassword, '3']);
    //     return redirect()->back();
    // }

    public function dashboard(Request $request) {
        try {
            $maxIdProtocol = DB::select('select max(id_protocol) from protocols');
            $textButton = "Изменить";
            if ($maxIdProtocol[0]->max === null) {
                $dateFormatted = '';
                $textButton = "Подтвердить";
            }
            else {
                $protocol = DB::select('select meeting_date, status from protocols where id_protocol = ?', [$maxIdProtocol[0]->max]);
                $date = new DateTime($protocol[0]->meeting_date);
                $dateFormatted = $date->format('Y-m-d');
                $currentDate = new DateTime();
                // для === проверка в login - если ===, то меняется статус на К утверждению
                if ($protocol[0]->status === 'Утвержден') {
                    $dateFormatted = '';
                    $textButton = "Подтвердить";
                }
            }
            $full_name = Auth::user()->full_name;
            $role = Auth::user()->role;
            $url = url('/show-works');
            return view('admin/admin_dashboard_layout', ["title" => "Обзор", "dateFormatted" => $dateFormatted, "textButton" => $textButton]);
        } catch (\Exception $exception) {
            error_log("{$exception->getMessage()}\n");
            return redirect()->back()->with(['message' => 'Произошла ошибка, попробуйте позже']);
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
            return redirect()->back();
        } catch (\Exception $exception) {
            error_log("{$exception->getMessage()}\n");
            return redirect()->back()->with(['message' => 'Произошла ошибка, попробуйте позже']);
        }
    }

    public function users() {
        try {
            $usersDB = DB::table('users')
                ->orderBy('id_user', 'asc')
                ->simplePaginate(10);
            return view('admin/admin_users_layout', ["title" => "Пользователи", "usersDB" => $usersDB]);
        } catch (\Exception $exception) {
            error_log("{$exception->getMessage()}\n");
            return redirect()->back()->with(['message' => 'Произошла ошибка, попробуйте позже']);
        }
    }

    public function saveUsers(Request $request) {
        try {
            if($request->input('user_ids') !== null) {
                $userIds = $request->input('user_ids');
                $roles = $request->input('roles');
                foreach ($userIds as $userId) {
                    DB::table('users')
                        ->where('id_user', $userId)
                        ->update(['role' => $roles[$userId]]);
                }
                return redirect()->back()->with('success', 'Данные успешно обновлены');
            }
            else {
                return redirect()->back();
            }
        } catch (\Exception $exception) {
            error_log("{$exception->getMessage()}\n");
            return redirect()->back()->with(['message' => 'Произошла ошибка, попробуйте позже']);
        }
    }

    public function works() {
        try {
            $worksDB = DB::table('works')
                ->orderBy('id_work', 'asc')
                ->simplePaginate(10);
            return view('admin/admin_works_layout', ["title" => "Работы", "worksDB" => $worksDB]);
        } catch (\Exception $exception) {
            error_log("{$exception->getMessage()}\n");
            return redirect()->back()->with(['message' => 'Произошла ошибка, попробуйте позже']);
        }
    }

    public function saveWorks(Request $request) {
        try {
            if($request->input('work_ids') !== null) {
                $workIds = $request->input('work_ids');
                $names = $request->input('names');
                $languages = $request->input('languages');
                $creatives = $request->input('creatives');
                $types = $request->input('types');
                $statuses = $request->input('statuses');
                $final_grades = $request->input('final_grades');
                $id_protocol = $request->input('ids_protocol');
                $original_percentes = $request->input('original_percentes');
                $created_at = $request->input('created_at');
                $links_library = $request->input('links_library');
                $links_file_extract_protocol = $request->input('links_file_extract_protocol');
                $links_pdf_file = $request->input('links_pdf_file');
                $links_text_file = $request->input('links_text_file');
                foreach ($workIds as $workId) {
                    DB::table('works')
                        ->where('id_work', $workId)
                        ->update([
                            'name_work' => $names[$workId],
                            'language' => $languages[$workId],
                            'creative' => isset($creatives[$workId]) && $creatives[$workId] == 'on' ? 1 : 0,
                            'type' => $types[$workId],
                            'status' => $statuses[$workId],
                            'final_grade' => $final_grades[$workId],
                            'id_protocol' => $id_protocol[$workId],
                            'original_percent' => $original_percentes[$workId],
                            'created_at' => $created_at[$workId],
                            'link_library' => $links_library[$workId],
                            'link_file_extract_protocol' => $links_file_extract_protocol[$workId],
                            'link_pdf_file' => $links_pdf_file[$workId],
                            'link_text_file' => $links_text_file[$workId],
                        ]);
                }
                return redirect()->back()->with('success', 'Данные успешно обновлены');
            }
            else {
                return redirect()->back();
            }
        } catch (\Exception $exception) {
            error_log("{$exception->getMessage()}\n");
            return redirect()->back()->with(['message' => 'Произошла ошибка, попробуйте позже']);
        }
    }

    public function protocols() {
        try {
            $protocolsDB = DB::table('protocols')
                ->orderBy('id_protocol', 'asc')
                ->simplePaginate(10);
            return view('admin/admin_protocols_layout', ["title" => "Протоколы", "protocolsDB" => $protocolsDB]);
        } catch (\Exception $exception) {
            error_log("{$exception->getMessage()}\n");
            return redirect()->back()->with(['message' => 'Произошла ошибка, попробуйте позже']);
        }
    }

    public function saveProtocols(Request $request) {
        try {
            if($request->input('protocol_ids') !== null) {
                $protocolIds = $request->input('protocol_ids');
                $meeting_dates = $request->input('meeting_dates');
                $links_protocol_file = $request->input('links_protocol_file');
                $statuses = $request->input('statuses');
                foreach ($protocolIds as $protocolId) {
                    $date = new DateTime($meeting_dates[$protocolId]);
                    $formattedDate = $date->format('d.m.Y');
                    $str = implode(" ", [$formattedDate]);
                    $filePath = storage_path('date.txt');
                    file_put_contents($filePath, $str);
                    DB::table('protocols')
                        ->where('id_protocol', $protocolId)
                        ->update([
                            'meeting_date' => $meeting_dates[$protocolId],
                            'link_protocol_file' => $links_protocol_file[$protocolId],
                            'status' => $statuses[$protocolId],
                        ]);
                }
                return redirect()->back()->with('success', 'Данные успешно обновлены');
            }
            else {
                return redirect()->back();
            }
        } catch (\Exception $exception) {
            error_log("{$exception->getMessage()}\n");
            return redirect()->back()->with(['message' => 'Произошла ошибка, попробуйте позже']);
        }
    }

    public function checkWorks() {
        try {
            $experts_worksDB = DB::table('experts_works')
                ->orderBy('id_user', 'asc')
                ->simplePaginate(10);
            $full_names_expertsDB = DB::table('experts_works')
                ->select('users.full_name')
                ->join('users', 'experts_works.id_user', '=', 'users.id_user')
                ->get();
            $names_worksDB = DB::table('experts_works')
                ->select('works.name_work')
                ->join('works', 'experts_works.id_work', '=', 'works.id_work')
                ->get();
            return view('admin/admin_experts_works_layout', ["title" => "Оценка работ", "experts_worksDB" => $experts_worksDB, "full_names_expertsDB" => $full_names_expertsDB, "names_worksDB" => $names_worksDB]);
        } catch (\Exception $exception) {
            error_log("{$exception->getMessage()}\n");
            return redirect()->back()->with(['message' => 'Произошла ошибка, попробуйте позже']);
        }
    }

    public function saveCheckWorks(Request $request) {
        try {
            if($request->input('user_ids') !== null || $request->input('work_ids') !== null) {
                $userIds = $request->input('user_ids');
                $workIds = $request->input('work_ids');
                $criterions1 = $request->input('criterions1');
                $criterions2 = $request->input('criterions2');
                $criterions3 = $request->input('criterions3');
                $criterions4 = $request->input('criterions4');
                $criterions5 = $request->input('criterions5');
                foreach ($userIds as $index => $userId) {
                    DB::table('experts_works')
                        ->where('id_user', $userId)
                        ->where('id_work', $workIds[$index])
                        ->update([
                            'criterion1' => $criterions1[$index],
                            'criterion2' => $criterions2[$index],
                            'criterion3' => $criterions3[$index],
                            'criterion4' => $criterions4[$index],
                            'criterion5' => $criterions5[$index],
                        ]);
                }
                return redirect()->back()->with('success', 'Данные успешно обновлены');
            }
            else {
                return redirect()->back();
            }
        } catch (\Exception $exception) {
            error_log("{$exception->getMessage()}\n");
            return redirect()->back()->with(['message' => 'Произошла ошибка, попробуйте позже']);
        }
    }

    public function subjectAreas() {
        try {
            $subject_areasDB = DB::table('subject_areas')
                ->orderBy('id_subject_area', 'asc')
                ->get();
            return view('admin/admin_subject_areas_layout', ["title" => "Предметные области", "subject_areasDB" => $subject_areasDB]);
        } catch (\Exception $exception) {
            error_log("{$exception->getMessage()}\n");
            return redirect()->back()->with(['message' => 'Произошла ошибка, попробуйте позже']);
        }
    }

    public function saveSubjectAreas(Request $request) {
        try {
            if($request->input('subject_area_ids') !== null) {
                $subject_areaIds = $request->input('subject_area_ids');
                $names_subject_area = $request->input('names_subject_area');
                foreach ($subject_areaIds as $index => $subject_areaId) {
                    DB::table('subject_areas')
                        ->where('id_subject_area', $subject_areaId)
                        ->update([
                            'name_subject_area' => $names_subject_area[$index],
                        ]);
                }
                return redirect()->back()->with('success', 'Данные успешно обновлены');
            }
            else {
                return redirect()->back();
            }
        } catch (\Exception $exception) {
            error_log("{$exception->getMessage()}\n");
            return redirect()->back()->with(['message' => 'Произошла ошибка, попробуйте позже']);
        }
    }
}
