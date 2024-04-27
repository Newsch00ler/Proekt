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
        return view('admin/admin_dashboard_layout', ["title" => "Обзор", "dateFormatted" => $dateFormatted, "textButton" => $textButton]);
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

    public function users() {
        $usersDB = DB::table('users')
            ->orderBy('id_user', 'asc')
            ->simplePaginate(10);
        return view('admin/admin_users_layout', ["title" => "Пользователи", "usersDB" => $usersDB]);
    }

    public function saveUsers(Request $request) {
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
    }

    public function works() {
        $worksDB = DB::table('works')
            ->orderBy('id_work', 'asc')
            ->simplePaginate(10);
        return view('admin/admin_works_layout', ["title" => "Работы", "worksDB" => $worksDB]);
    }

    public function saveWorks(Request $request) {
        if($request->input('work_ids') !== null) {
            $workIds = $request->input('work_ids');
            $names = $request->input('names');
            $languages = $request->input('languages');
            $creatives = $request->input('creatives');
            $signatures = $request->input('signatures');
            $verification_statuses = $request->input('verification_statuses');
            $id_protocol = $request->input('ids_protocol');
            $original_percentes = $request->input('original_percentes');
            $created_at = $request->input('created_at');
            $links_library = $request->input('links_library');
            $links_file_extract_protocol = $request->input('links_file_extract_protocol');
            $links_text_file = $request->input('links_text_file');
            $validations = $request->input('validations');
            foreach ($workIds as $workId) {
                DB::table('works')
                    ->where('id_work', $workId)
                    ->update([
                        'name_work' => $names[$workId],
                        'language' => $languages[$workId],
                        'creative' => isset($creatives[$workId]) && $creatives[$workId] == 'on' ? 1 : 0,
                        'signature' => $signatures[$workId],
                        'verification_status' => isset($verification_statuses[$workId]) && $verification_statuses[$workId] == 'on' ? 1 : 0,
                        'id_protocol' => $id_protocol[$workId],
                        'original_percent' => $original_percentes[$workId],
                        'created_at' => $created_at[$workId],
                        'link_library' => $links_library[$workId],
                        'link_file_extract_protocol' => $links_file_extract_protocol[$workId],
                        'link_text_file' => $links_text_file[$workId],
                        'validation' => isset($validations[$workId]) && $validations[$workId] == 'on' ? 1 : 0,
                    ]);
            }
            return redirect()->back()->with('success', 'Данные успешно обновлены');
        }
        else {
            return redirect()->back();
        }
    }

    public function protocols() {
        $protocolsDB = DB::table('protocols')
            ->orderBy('id_protocol', 'asc')
            ->simplePaginate(10);
        return view('admin/admin_protocols_layout', ["title" => "Протоколы", "protocolsDB" => $protocolsDB]);
    }

    public function saveProtocols(Request $request) {
        if($request->input('protocol_ids') !== null) {
            $protocolIds = $request->input('protocol_ids');
            $meeting_dates = $request->input('meeting_dates');
            $links_protocol_file = $request->input('links_protocol_file');
            $statuses = $request->input('statuses');
            foreach ($protocolIds as $protocolId) {
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
    }

    public function checkWorks() {
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
    }

    public function saveCheckWorks(Request $request) {
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
    }

    public function subjectAreas() {
        $subject_areasDB = DB::table('subject_areas')
            ->orderBy('id_subject_area', 'asc')
            ->get();
        return view('admin/admin_subject_areas_layout', ["title" => "Предметные области", "subject_areasDB" => $subject_areasDB]);
    }

    public function saveSubjectAreas(Request $request) {
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
    }
}
