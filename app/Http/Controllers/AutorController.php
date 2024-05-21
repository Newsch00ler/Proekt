<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Work;
use App\Models\User;
use App\Models\SubjectArea;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use DateTime;

class AutorController extends Controller
{
    public function showPageLoadMyWork(){
        try {
            $maxIdProtocol = DB::select('select max(id_protocol) from protocols');
            $dateFormatted = '';
            if ($maxIdProtocol[0]->max === null) {
                $isDisabled = false;
                $isVisible = false;
            }
            else {
                $protocol = DB::select('select meeting_date, status from protocols where id_protocol = ?', [$maxIdProtocol[0]->max]);
                $date = new DateTime($protocol[0]->meeting_date);
                $date->modify('+1 days');
                $dateFormatted = $date->format('d.m.Y');
                $currentDate = new DateTime();
                if ($protocol[0]->status === 'Утвержден') {
                    $isDisabled = false;
                    $isVisible = false;
                }
                else {
                    if ($currentDate->modify('+6 days') < $date) {
                        $isDisabled = false;
                        $isVisible = false;
                    }
                    else {
                        $isDisabled = true;
                        $isVisible = true;
                    }
                }
            }
            $subjectAreasDB = DB::select('select * from subject_areas');
            $full_name = Auth::user()->full_name;
            $role = Auth::user()->role;
            if ($role === 'Председатель' || $role === 'Секретарь'){
                $url = url('/show-works');
            }
            else if ($role === 'Эксперт'){
                $url = url('/e-show-works');
            }
            else if ($role === 'Автор'){
                $url = url('/my-works');
            }
            $viewRole = 'Автор';
        } catch (\Exception $exception) {
            error_log("Ошибка выполнения запроса в БД: {$exception->getMessage()}\n");
            return redirect()->back()->withInput();
        }
        return view('autors/autors_download_layout', ["title" => "Загрузка работы", "message" => "Пожалуйста, заполните все поля и загрузите все файлы", "subjectAreas" => $subjectAreasDB, 'date' => $dateFormatted, 'isDisabled' => $isDisabled, 'isVisible' => $isVisible, 'url' => $url, 'full_name' => $full_name, 'role' => $role, 'viewRole' => $viewRole]);
    }

    // отображение работ только авторизованного пользователя
    public function showPageMyWorks() {
        try {
            $worksDB = DB::select('select works.name_work,
                STRING_AGG(subject_areas.name_subject_area, \', \') as name_subject_area,
                works.original_percent as original_percent,
                works.created_at as created_at,
                works.final_grade as final_grade,
                works.status as status,
                SPLIT_PART(link_pdf_file, \'\\\', -1) AS file_name,
                SPLIT_PART(works.link_text_percent1, \'\\\', -1) as file_text_percent1,
                SPLIT_PART(works.link_text_percent2, \'\\\', -1) as file_text_percent2,
                SPLIT_PART(works.link_text_percent3, \'\\\', -1) as file_text_percent3,
                SPLIT_PART(works.link_text_percent4, \'\\\', -1) as file_text_percent4,
                SPLIT_PART(works.link_text_percent5, \'\\\', -1) as file_text_percent5,
                works.percent1 as percent1,
                works.percent2 as percent2,
                works.percent3 as percent3,
                works.percent4 as percent4,
                works.percent5 as percent5
                from works
                inner join autors_works on works.id_work = autors_works.id_work
                inner join works_subject_areas on works.id_work = works_subject_areas.id_work
                inner join subject_areas on works_subject_areas.id_subject_area  = subject_areas.id_subject_area
                where autors_works.id_user = ?
                group by works.id_work
                order by works.created_at asc', [Auth::user()->id_user]);
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
            $full_name = Auth::user()->full_name;
            $role = Auth::user()->role;
            if ($role === 'Председатель' || $role === 'Секретарь'){
                $url = url('/show-works');
            }
            else if ($role === 'Эксперт'){
                $url = url('/e-show-works');
            }
            else if ($role === 'Автор'){
                $url = url('/my-works');
            }
            $viewRole = 'Автор';
        } catch (\Exception $exception) {
            error_log("Ошибка выполнения запроса в БД: {$exception->getMessage()}\n");
            return redirect()->back()->withInput();
        }
        return view('autors/autors_works_layout', ["title" => "Мои работы", "message1" => $message1,  "worksDB" => $worksDB, "countAllWorks" => $countAllWorks, "countAllVerifiedWorks" => $countAllVerifiedWorks, "countAllUnverifiedWorks" => $countAllUnverifiedWorks, "countAllRejectedWorks" => $countAllRejectedWorks, 'url' => $url, 'full_name' => $full_name, 'role' => $role, 'viewRole' => $viewRole]);
    }

    public function uploadProcess(Request $request){
        $message = "";
        // 1. Загрузка файла
        $workNameInput = $request->input('nameWork'); //получение значений
        $typeWorkSelect = $request->input('typeWork');
        $subjectAreaSelect = $request->input('subjectAreaWork', []);
        $uploadedFile1Input = $request->file('uploadedFile1');
        $uploadedFile2Input = $request->file('uploadedFile2');
        $uploadedFile3Input = $request->file('uploadedFile4');
        $uploadedFile4Input = $request->file('uploadedFile4');
        if ((!empty($workNameInput) && !empty($typeWorkSelect) && !empty($subjectAreaSelect)) &&
        ((!empty($uploadedFile1Input) && !empty($uploadedFile2Input)) || // !empty($workLinkInput) &&
        (!empty($uploadedFile3Input) && !empty($uploadedFile4Input)))){ // доп. проверка на пустоту
            $destinationPdfPath = public_path('loadPdfFiles\\'); // для хранения именно pdf
            $destinationTxtPath = public_path('loadTxtFiles\\'); // для хранения именно txt
            $destinationExtractPath = public_path('loadExtractFiles\\'); // для хранения выписок
            $ulpoadFiles = [];
            for ($i = 1; $i < 5; $i++) {
                $fileHtmlName = "uploadedFile$i";
                if ($request->hasFile($fileHtmlName)){
                    $file = $request->file($fileHtmlName); // имя файла в HTML
                    $ulpoadFiles[] = $file;
                }
            }
            $ulpoadFiles1 = [];
            foreach ($ulpoadFiles as $file) {
                $parts = pathinfo($file->getClientOriginalName());
                $fileExtension = $parts['extension'];
                $randomBytes = random_bytes(16); // генерация уникальной строки длиной 16
                $randomString = bin2hex($randomBytes); // преобразование случайных байтов в строку шестнадцатеричных символов
                $randomStringWithoutSpaces = str_replace(' ', '', $randomString); // удаление пробелов из сгенерированной строки
                $newFileName = $randomStringWithoutSpaces . '.' . $fileExtension;
                if ($fileExtension == "pdf"){
                    $file->move($destinationPdfPath, $newFileName);
                    $ulpoadFiles1[] = $newFileName;
                } else if ($fileExtension == "jpg" or $fileExtension == "JPG" or $fileExtension == "jpeg" or $fileExtension == "JPEG") {
                    $file->move($destinationExtractPath, $newFileName);
                    $ulpoadFiles1[] = $newFileName;
                }
            }

            // if (strlen($workNameInput) > 0) {
            //     $scriptPath = public_path('scripts\OpacDetect.py');
            //     // 2. Вызов Python скрипта для проверки наименования в библиотеке
            //     $successOpacDetect = $this->OpacDetect($scriptPath, escapeshellarg($workNameInput));
            // }

            $pdfFilePath = public_path('loadPdfFiles\\' . $ulpoadFiles1[0]);
            $pdfFileName = substr(basename($pdfFilePath), 0, -4);
            $txtFilePath = public_path("loadTxtFiles\\" . $pdfFileName . ".txt");
            // $successOpacDetect = true;
                    dd(1);
            if ($request->hasFile('uploadedFile1')) { //$successOpacDetect === true &&
                $scriptPath = public_path('scripts\TranslatePDFtoTXTScript.py');
                $fileHandle = fopen($txtFilePath, 'w');
                fclose($fileHandle);
                // 3. Вызов Python скрипта из пдф в ткст + получение кол-ва страниц
                $successConvertPdfToText = $this->convertPdfToText($scriptPath, $pdfFilePath, $txtFilePath);
            } else {
                $this->deleteFiles($destinationExtractPath, $ulpoadFiles1, $destinationPdfPath, $txtFilePath);
                return redirect()->back()->withInput();
            }

            if ($successConvertPdfToText['success'] === true) {
                $scriptPath = public_path('scripts\DetectLanguage.py');
                // 4. Вызов Python скрипта для проверки языка работы
                $successLanguage = $this->detectLanguage($scriptPath, $txtFilePath);
            } else {
                $this->deleteFiles($destinationExtractPath, $ulpoadFiles1, $destinationPdfPath, $txtFilePath);
                return redirect()->back()->withInput();
            }

            if ($successLanguage['success'] === true) {
                $scriptPath = public_path('scripts\TextOriginalityScript.py');
                $check_directory = public_path('loadTxtFiles\\');
                // 5. Вызов Python скрипта для проверки оригинальности
                $successOriginality = $this->checkOriginality($scriptPath, $txtFilePath, $check_directory);
            } else {
                $this->deleteFiles($destinationExtractPath, $ulpoadFiles1, $destinationPdfPath, $txtFilePath);
                return redirect()->back()->withInput();
            }

            if ($successOriginality['success'] === true) {
                // 6. Проверка выписки и наименования
                $scriptPath = public_path('scripts\Recognitions.py');
                $extractFilePath = $destinationExtractPath . $ulpoadFiles1[1];
                $successCheckExtractFile = $this->checkExtractFile($scriptPath, $extractFilePath, $workNameInput);
            } else {
                $this->deleteFiles($destinationExtractPath, $ulpoadFiles1, $destinationPdfPath, $txtFilePath);
                return redirect()->back()->withInput();
            }

            if ($successCheckExtractFile['success'] === true) {
                // 7. Сохранение результатов в БД
                $original_percent = 100 - floatval($successOriginality['percentsList'][0]);
                $link_text_percent = [];
                $percents = [];
                for ($i = 1; $i <= 5; $i++) {
                    $link_text_percent[$i] = public_path('loadPdfFiles\\' . substr($successOriginality['percentsList'][2 * $i - 1], 0, -6)  . '.pdf');
                    $percents[$i] = floatval($successOriginality['percentsList'][2 * $i]);
                }
                $publisher = null;
                $publishing_year = null;
                $successSaveWorkDB = $this->saveResultsToDatabase($workNameInput, $successLanguage['language'], "false", "Не подтверждена", null, null, $original_percent, $destinationExtractPath . $ulpoadFiles1[1], $txtFilePath, $pdfFilePath, $subjectAreaSelect, $typeWorkSelect, $link_text_percent, $percents, $publisher, $publishing_year, $successConvertPdfToText['pages_number']);
            } else {
                $this->deleteFiles($destinationExtractPath, $ulpoadFiles1, $destinationPdfPath, $txtFilePath);
                return redirect()->back()->withInput();
            }

            if ($successSaveWorkDB === true) {
                return redirect()->route('my.works');
            } else {
                $this->deleteFiles($destinationExtractPath, $ulpoadFiles1, $destinationPdfPath, $txtFilePath);
                return redirect()->back()->withInput();
            }
        } else {
            return redirect()->back()->withInput();
        }
    }

    private function OpacDetect($scriptPath, $workName){
        $success = false;
        try {
            $command = "py $scriptPath $workName 2>&1";
            $answer = exec($command);
            if ($answer === "True") {
                $success = true;
            }
        } catch (ProcessFailedException $exception) {
            error_log("Ошибка выполнения скрипта Python: {$exception->getMessage()}\n");
        }
        return $success;
    }

    private function convertPdfToText($scriptPath, $pdfFilePath, $txtFilePath){
        $success = false;
        try {
            $command = "py $scriptPath $pdfFilePath $txtFilePath 2>&1";
            $pages_number = exec($command);
            if (filesize($txtFilePath) > 0) {
                $success = true;
            }
        } catch (ProcessFailedException $exception) {
            error_log("Ошибка выполнения скрипта Python: {$exception->getMessage()}\n");
        }
        return ['pages_number' => intval($pages_number), 'success' => $success];
    }

    private function detectLanguage($scriptPath, $txtFilePath){
        $success = false;
        try {
            $command = "py $scriptPath $txtFilePath 2>&1";
            $language = exec($command);
            if (strlen($language) > 0) {
                $success = true;
            }
        } catch (ProcessFailedException $exception) {
            error_log("Ошибка выполнения скрипта Python: {$exception->getMessage()}\n");
        }
        return ['language' => $language, 'success' => $success];
    }

    private function checkOriginality($scriptPath, $txtFilePath, $check_directory){
        $success = false;
        try {
            $command = "py $scriptPath $txtFilePath $check_directory 2>&1";
            $percent = exec($command);
            if ($percent !== null) {
                $success = true;
            }
            $output_list = file(public_path('\scripts\resultOrig.txt', FILE_IGNORE_NEW_LINES));
        } catch (ProcessFailedException $exception) {
            error_log("Ошибка выполнения скрипта Python: {$exception->getMessage()}\n");
        }
        return ['percentsList' => $output_list, 'success' => $success];
    }

    // Магматические комплексы Мамской мусковитоносной провинции

    private function checkExtractFile($scriptPath, $extractFilePath, $workNameInput){
        $success = false;
        try {
            $command = "py $scriptPath $extractFilePath 2>&1";
            exec($command);
            $test = file(public_path('\scripts\resultRec.txt', FILE_IGNORE_NEW_LINES));
            $test = array_map(function($item) {
                return str_replace(["\r", "\n"], "", $item);
            }, $test);
            $string = implode("", $test);
            $nameWords = explode(" ", $workNameInput);
            foreach($nameWords as $word) {
                $found = strpos($string, $word) !== false;
                if (!$found) {
                    $success = false;
                    break;
                } else {
                    $success = true;
                }
            }
        } catch (ProcessFailedException $exception) {
            error_log("Ошибка выполнения скрипта Python: {$exception->getMessage()}\n");
        }
        return ['success' => $success];
    }

    private function saveResultsToDatabase($name_work, $language, $creative, $status, $final_grade, $id_protocol, $original_percent, $link_file_extract_protocol, $link_text_file, $link_pdf_file, $subjectAreaSelect, $typeWorkSelect, $link_text_percent, $percents, $publisher, $publishing_year, $pages_number){
        $success = false;
        try {
            $newWork = [
                'name_work' => $name_work,
                'language' => $language,
                'creative' => $creative,
                'status' => $status,
                'final_grade' => $final_grade,
                'id_protocol' => $id_protocol,
                'original_percent' => $original_percent,
                'created_at' => now(),
                'link_file_extract_protocol' => $link_file_extract_protocol,
                'link_text_file' => $link_text_file,
                'link_pdf_file' => $link_pdf_file,
                'type' => $typeWorkSelect,
                'link_text_percent1' => $link_text_percent[1],
                'link_text_percent2' => $link_text_percent[2],
                'link_text_percent3' => $link_text_percent[3],
                'link_text_percent4' => $link_text_percent[4],
                'link_text_percent5' => $link_text_percent[5],
                'percent1' => $percents[1],
                'percent2' => $percents[2],
                'percent3' => $percents[3],
                'percent4' => $percents[4],
                'percent5' => $percents[5],
                'publisher' => $publisher,
                'publishing_year' => $publishing_year,
                'pages_number' => $pages_number
            ];
            // добавление работы в БД
            $createdWork = DB::table('works')->insert($newWork);
            // добавление связи работы с предметными областями в БД
            $subjectAreaIds = [];
            foreach($subjectAreaSelect as $subjectArea) {
                $resultDB = DB::select('select id_subject_area from subject_areas where name_subject_area = ?', [$subjectArea]);
                foreach ($resultDB as $item) {
                    $subjectAreaIds[] = $item->id_subject_area;
                }
            }
            $maxWorkId = DB::table('works')->max('id_work');

            foreach($subjectAreaIds as $subjectAreaId) {
                $createdWorkSubjectArea = DB::insert('insert into works_subject_areas (id_work, id_subject_area) values (?, ?)', [$maxWorkId, $subjectAreaId]);
            }
            // добавление связи работы с пользователем в БД
            $createdUserWork = DB::table('autors_works')->insert([
                'id_user' => Auth::user()->id_user,
                'id_work' => $maxWorkId
            ]);

            if ($createdWork && $createdWorkSubjectArea && $createdUserWork) {
                $success = true;
            }
        } catch (\Exception $exception) {
            error_log("Ошибка выполнения запроса в БД: {$exception->getMessage()}\n");
        }
        return $success;
    }

    private function deleteFiles($destinationExtractPath, $ulpoadFiles1, $destinationPdfPath, $txtFilePath){
        if (file_exists($destinationExtractPath . $ulpoadFiles1[1])) {
            chmod($destinationExtractPath . $ulpoadFiles1[1], 0755);
            unlink($destinationExtractPath . $ulpoadFiles1[1]);
        }
        if (file_exists($destinationPdfPath . $ulpoadFiles1[0])) {
            chmod($destinationPdfPath . $ulpoadFiles1[0], 0755);
            unlink($destinationPdfPath . $ulpoadFiles1[0]);
        }
        if (file_exists($txtFilePath)) {
            chmod($txtFilePath, 0755);
            unlink($txtFilePath);
        }
    }
}
