<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Work;
use App\Models\SubjectArea;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class AutorWorkController extends Controller
{

    public function showPageLoadMyWork(){
        $subjectAreasDB = DB::select('select * from subject_areas');
        return view('autors/autors_download_layout', ["title" => "Загрузка работы", "message" => "Пожалуйста, заполните все поля и загрузите все файлы", "subjectAreas" => $subjectAreasDB]);
    }

    public function showPageMyWorks() {
        $worksDB = DB::select('select * from my_works');
        $countAllWorks = DB::select('select COUNT(*) from works');
        $countAllVerifiedWorks = DB::select('select COUNT(*) from works where verification_status = true');
        $countAllUnverifiedWorks = DB::select('select COUNT(*) from works where verification_status = false');
        return view('autors/autors_works_layout', ["title" => "Мои работы", "message" => "", "worksDB" => $worksDB, "countAllWorks" => $countAllWorks[0]->count, "countAllVerifiedWorks" => $countAllVerifiedWorks[0]->count, "countAllUnverifiedWorks" => $countAllUnverifiedWorks[0]->count]); //"url" => "/myWorksTest", "method" => "get",
    }

    public function uploadProcess(Request $request){
        $subjectAreasDB = DB::select('select * from subject_areas');
        $subjectAreasArray = json_decode(json_encode($subjectAreasDB), true);
        $worksDB = DB::select('select * from my_works');
        $countAllWorks = DB::select('select COUNT(*) from works');
        $countAllVerifiedWorks = DB::select('select COUNT(*) from works where verification_status = true');
        $countAllUnverifiedWorks = DB::select('select COUNT(*) from works where verification_status = false');
        $message = "";
        $pythonPath = realpath('C:\Users\Home\AppData\Local\Programs\Python\Python312\python.exe');
        // 1. Загрузка файла
        $workNameInput = $request->input('nameWork'); //получение значений
        $typeWorkSelect = $request->input('typeWork');
        $subjectAreaSelect = $request->input('subjectAreaWork');
        $uploadedFile1Input = $request->file('uploadedFile1');
        $uploadedFile2Input = $request->file('uploadedFile2');
        $uploadedFile3Input = $request->file('uploadedFile4');
        $uploadedFile4Input = $request->file('uploadedFile4');
        $workLinkInput = $request->input('linkWork');
        if ((!empty($workNameInput) && !empty($typeWorkSelect) && !empty($subjectAreaSelect)) &&
        ((!empty($workLinkInput) && !empty($uploadedFile1Input) && !empty($uploadedFile2Input)) ||
        (!empty($uploadedFile3Input) && !empty($uploadedFile4Input)))){ //проверка на пустоту
            $destinationPdfPath = public_path('loadPdfFiles\\');
            $destinationExtractPath = public_path('loadExtractFiles\\');
            $ulpoadFiles = [];
            for ($i = 1; $i < 5; $i++) {
                $fileHtmlName = "uploadedFile$i";

                if ($request->hasFile($fileHtmlName)){
                    $file = $request->file($fileHtmlName);
                    $fileName = $file->getClientOriginalName();
                    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

                    if ($fileExtension == "pdf"){
                        if (file_exists("{$destinationPdfPath}/{$fileName}")) {
                            $message = "Файл с именем {$fileName} уже существует";
                            return redirect()->back();
                        }
                    } else if ($fileExtension == "png" or $fileExtension == "jpg") {
                        if (file_exists("{$destinationExtractPath}/{$fileName}")) {
                            $message = "Файл с именем {$fileName} уже существует.";
                            return redirect()->back();
                        }
                    }
                    $ulpoadFiles[] = $file;
                }
            }

            // надо подумать, мб кудто-то перенести надо, чтобы убрать ниже постоянные удаления
            foreach ($ulpoadFiles as $file) {
                $fileName = $file->getClientOriginalName();
                $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
                if ($fileExtension == "pdf"){
                    $file->move($destinationPdfPath, $fileName);
                } else if ($fileExtension == "png" or $fileExtension == "jpg") {
                    $file->move($destinationExtractPath, $fileName);
                }
            }

            if ($request->hasFile('uploadedFile1')) {
                $scriptPath = public_path('scripts\TranslatePDFtoTXTScript.py');
                $pdfFilePath = public_path('loadPdfFiles\\' . $request->file('uploadedFile1')->getClientOriginalName());
                $pdfFileName = substr($request->file('uploadedFile1')->getClientOriginalName(), 0, -4);
                $txtFilePath = public_path("loadTxtFiles\\" . $pdfFileName . ".txt");
                // 2. Вызов Python скрипта для конвертации PDF в текст
                $successConvertPdfToText = $this->convertPdfToText($pythonPath, $scriptPath, $pdfFilePath, $txtFilePath);
            }

            if ($successConvertPdfToText === true) {
                $scriptPath = public_path('scripts\TextOriginalityScript.py');
                $check_directory = public_path('test2\\');
                // 3. Вызов Python скрипта для проверки оригинальности
                $successOriginality = $this->checkOriginality($pythonPath, $scriptPath, $txtFilePath, $check_directory);
            } else {
                if (file_exists($destinationExtractPath . $ulpoadFiles[1]->getClientOriginalName())) {
                    chmod($destinationExtractPath . $ulpoadFiles[1]->getClientOriginalName(), 0755);
                    unlink($destinationExtractPath . $ulpoadFiles[1]->getClientOriginalName());
                }
                if (file_exists($destinationPdfPath . $ulpoadFiles[0]->getClientOriginalName())) {
                    chmod($destinationPdfPath . $ulpoadFiles[0]->getClientOriginalName(), 0755);
                    unlink($destinationPdfPath . $ulpoadFiles[0]->getClientOriginalName());
                }
                if (file_exists($txtFilePath)) {
                    chmod($txtFilePath, 0755);
                    unlink($txtFilePath);
                }
                return redirect()->back();
                trigger_error("Failed to execute Python script", E_USER_ERROR);
            }

            if ($successOriginality['success'] === true) {
                // 4. Сохранение результатов в БД
                $successSaveWorkDB = $this->saveResultsToDatabase($workNameInput, "", "false",  "", "false", null, null, $successOriginality['percent'], $workLinkInput, $destinationExtractPath . $ulpoadFiles[1]->getClientOriginalName(), $txtFilePath, $subjectAreaSelect);
            } else {
                if (file_exists($destinationExtractPath . $ulpoadFiles[1]->getClientOriginalName())) {
                    chmod($destinationExtractPath . $ulpoadFiles[1]->getClientOriginalName(), 0755);
                    unlink($destinationExtractPath . $ulpoadFiles[1]->getClientOriginalName());
                }
                if (file_exists($destinationPdfPath . $ulpoadFiles[0]->getClientOriginalName())) {
                    chmod($destinationPdfPath . $ulpoadFiles[0]->getClientOriginalName(), 0755);
                    unlink($destinationPdfPath . $ulpoadFiles[0]->getClientOriginalName());
                }
                if (file_exists($txtFilePath)) {
                    chmod($txtFilePath, 0755);
                    unlink($txtFilePath);
                }
                return redirect()->back();
                trigger_error("Failed to save results to database", E_USER_ERROR);
            }

            // if ($successSaveWorkDB === true) {
            //     // 5. Получение результатов из БД
            //     $successGetWorksDB = $this->getResultsFromDatabase();
            // } else {
            //     if (file_exists($destinationExtractPath . $ulpoadFiles[1]->getClientOriginalName())) {
            //         chmod($destinationExtractPath . $ulpoadFiles[1]->getClientOriginalName(), 0755);
            //         unlink($destinationExtractPath . $ulpoadFiles[1]->getClientOriginalName());
            //     }
            //     if (file_exists($destinationPdfPath . $ulpoadFiles[0]->getClientOriginalName())) {
            //         chmod($destinationPdfPath . $ulpoadFiles[0]->getClientOriginalName(), 0755);
            //         unlink($destinationPdfPath . $ulpoadFiles[0]->getClientOriginalName());
            //     }
            //     if (file_exists($txtFilePath)) {
            //         chmod($txtFilePath, 0755);
            //         unlink($txtFilePath);
            //     }
            //     return redirect()->back();
            //     trigger_error("Failed to save results to database", E_USER_ERROR);
            // }

            if ($successSaveWorkDB === true) {
                return redirect()->route('seeMyWorks');
            } else {
                if (file_exists($destinationExtractPath . $ulpoadFiles[1]->getClientOriginalName())) {
                    chmod($destinationExtractPath . $ulpoadFiles[1]->getClientOriginalName(), 0755);
                    unlink($destinationExtractPath . $ulpoadFiles[1]->getClientOriginalName());
                }
                if (file_exists($destinationPdfPath . $ulpoadFiles[0]->getClientOriginalName())) {
                    chmod($destinationPdfPath . $ulpoadFiles[0]->getClientOriginalName(), 0755);
                    unlink($destinationPdfPath . $ulpoadFiles[0]->getClientOriginalName());
                }
                if (file_exists($txtFilePath)) {
                    chmod($txtFilePath, 0755);
                    unlink($txtFilePath);
                }
                return redirect()->back();
                trigger_error("Failed to save results to database", E_USER_ERROR);
            }
        } else {
            return redirect()->back();
        }
    }

    private function convertPdfToText($pythonPath, $scriptPath, $pdfFilePath, $txtFilePath){
        $success = false;
        $process = new Process([$pythonPath, $scriptPath, $pdfFilePath, $txtFilePath]);
        try {
            $process->mustRun();
            if ($process->isSuccessful()) {
                // Скрипт успешно выполнился
                $output = $process->getOutput();
                $success = true;
            } else {
                // Скрипт завершился с ошибкой
                $errorOutput = $process->getErrorOutput();
                error_log("Скрипт не выполнился: {$errorOutput}");
            }
        } catch (ProcessFailedException $exception) {
            // Процесс не удалось запустить
            error_log("Ошибка выполнения скрипта Python: {$exception->getMessage()}\n");
            dd("Ошибка выполнения скрипта Python: {$exception->getMessage()}\n");
        }
        return $success;
    }

    private function checkOriginality($pythonPath, $scriptPath, $txtFilePath, $check_directory){
        $success = false;
        try {
            $command = "$pythonPath $scriptPath $txtFilePath $check_directory 2>&1";
            $percent = exec($command);
            if ($percent !== null) {
                $success = true;
            }
        } catch (ProcessFailedException $exception) {
            // Процесс не удалось запустить
            error_log("Ошибка выполнения скрипта Python: {$exception->getMessage()}\n");
            dd("Ошибка выполнения скрипта Python: {$exception->getMessage()}\n");
        }
        return ['percent' => floatval($percent), 'success' => $success];
    }

    private function saveResultsToDatabase($name_work, $language, $creative, $signature, $verification_status, $final_grade, $id_protocol, $original_percent, $link_library, $link_file_extract_protocol, $link_text_file, $subjectAreaSelect){
        $success = false;
        try {
            $newWork = [
                'name_work' => $name_work,
                'signature' => $signature,
                'language' => $language,
                'creative' => $creative,
                'verification_status' => $verification_status,
                'final_grade' => $final_grade,
                'id_protocol' => $id_protocol,
                'original_percent' => $original_percent,
                'created_at' => now(),
                'link_library' => $link_library,
                'link_file_extract_protocol' => $link_file_extract_protocol,
                'link_text_file' => $link_text_file
            ];
            $createdWork = DB::table('works')->insert($newWork);

            $createdWorkSubjectArea = DB::statement('
                WITH subject_area_data AS (
                    SELECT id_subject_area
                    FROM subject_areas
                    WHERE name_subject_area = :subjectAreaSelect
                )
                INSERT INTO works_subject_areas (id_work, id_subject_area)
                VALUES (
                    (SELECT MAX(id_work) FROM works),
                    (SELECT id_subject_area FROM subject_area_data)
                )
            ', ['subjectAreaSelect' => $subjectAreaSelect]);
            if ($createdWork && $createdWorkSubjectArea) {
                $success = true;
            }
        } catch (\Exception $e) {
            // Обработка ошибки при сохранении данных в БД
            dd("Failed to save results to database: " . $e->getMessage(), E_USER_ERROR);
            trigger_error("Failed to save results to database: " . $e->getMessage(), E_USER_ERROR);
        }
        return $success;
    }

    // private function getResultsFromDatabase(){
    //     $success = false;
    //     $worksDB = DB::select('select * from my_works');
    //     if ($worksDB !== false) {
    //         $success = true;
    //     }
    //     return ['worksDB' => $worksDB, 'success' => $success];
    // }


    // в принципе ненужное
    // public function upload(Request $request) {
    //     $message = "";
    //     $textInput1 = $request->input('workName');
    //     $selectValue1 = $request->input('typeWork');
    //     $selectValue2 = $request->input('subAreaWork');
    //     $textInput2 = $request->input('workLink');

    //     if (!empty($textInput1) && !empty($selectValue1) && !empty($selectValue2) && !empty($textInput2)){
    //         $destinationPdfPath = public_path('loadPdfFiles');
    //         $destinationExtractPath = public_path('loadExtractFiles');
    //         $ulpoadFiles = [];

    //         for ($i = 1; $i < 5; $i++) {
    //             $fileHtmlName = "uploadedFile$i";

    //             if ($request->hasFile($fileHtmlName)){
    //                 $file = $request->file($fileHtmlName);
    //                 $fileName = $file->getClientOriginalName();
    //                 $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

    //                 if ($fileExtension == "pdf"){
    //                     if (file_exists("{$destinationPdfPath}/{$fileName}")) {
    //                         $message = "Файл с именем {$fileName} уже существует.";
    //                         return view('autors/autors_download_layout', [
    //                             "title" => "Загрузка работы",
    //                             "url" => "/loadMyWork",
    //                             "method" => "",
    //                             "message" => $message,
    //                             "subjectAreas" => app(SubjectAreasController::class)->getSubjectAreas1(),
    //                             "showModal" => true
    //                         ]);
    //                         //return view('autors/autors_download_layout', ["title" => "Загрузка работ", "message" => $message]);
    //                         //return view('main_layout')->with('message', $output);
    //                         //return $message;
    //                     }
    //                 } else if ($fileExtension == "png" or $fileExtension == "jpg") {
    //                     if (file_exists("{$destinationExtractPath}/{$fileName}")) {
    //                         $message = "Файл с именем {$fileName} уже существует.";
    //                         return view('autors/autors_download_layout', (string)$message);
    //                         //return view('autors/autors_download_layout', ["title" => "Загрузка работ", "message" => $message]);
    //                         //return redirect()->route('showPopup', ['message' => "Файл с именем {$fileName} уже существует в папке."]);
    //                         //return $message;
    //                     }
    //                 }
    //                 $ulpoadFiles[] = $file;
    //             }
    //         }

    //         foreach ($ulpoadFiles as $file) {
    //             $fileName = $file->getClientOriginalName();
    //             $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    //             if ($fileExtension == "pdf"){
    //                 $file->move($destinationPdfPath, $fileName);
    //             } else if ($fileExtension == "png" or $fileExtension == "jpg") {
    //                 $file->move($destinationExtractPath, $fileName);
    //             }
    //         }

    //         if ($request->hasFile('uploadedFile1')) {
    //             $pythonPath =  realpath('C:\Users\Home\AppData\Local\Programs\Python\Python312\python.exe');
    //             $scriptPath = public_path('scripts\TranslatePDFtoTXTScript.py');
    //             $pdfFilePath = public_path('loadPdfFiles/' . $request->file('uploadedFile1')->getClientOriginalName());
    //             $pdfFileName = substr($request->file('uploadedFile1')->getClientOriginalName(), 0, -4);
    //             $txtFilePath = public_path("loadTxtFiles/" . $pdfFileName . ".txt");

    //             $process = new Process([$pythonPath, $scriptPath, $pdfFilePath, $txtFilePath]);
    //             try {
    //                 $process->mustRun();
    //                 if ($process->isSuccessful()) {
    //                     // Скрипт успешно выполнился
    //                     $output = $process->getOutput();
    //                     //return view('main_layout')->with('message', $output);
    //                     //echo "Скрипт успешно выполнился";
    //                 } else {
    //                     // Скрипт завершился с ошибкой
    //                     $errorOutput = $process->getErrorOutput();
    //                     error_log("Скрипт не выполнился: {$errorOutput}");
    //                 }
    //                 $process->getErrorOutput();
    //             } catch (ProcessFailedException $exception) {
    //                 dd($exception->getMessage());
    //                 // Процесс не удалось запустить
    //                 error_log("Ошибка выполнения скрипта Python: {$exception->getMessage()}\n");
    //             }
    //         }

    //         if (!empty($ulpoadFiles) && isset($ulpoadFiles[1])){
    //             $message = "Наименование: $textInput1<br>
    //                 Вид работы: $selectValue1<br>
    //                 Предметная область: $selectValue2<br>
    //                 Ссылка на выписку из протокола: $textInput2<br>
    //                 Файл $ulpoadFiles[0] успешно загружен в $destinationPdfPath<br>
    //                 Файл $ulpoadFiles[1] успешно загружен в $destinationExtractPath";
    //             //return view('autors/autors_works_layout', ["title" => "Мои работы"]);
    //             //return view('autors/autors_download_layout', ["title" => "Загрузка работ", "message" => $message]);
    //             //return $message;
    //             return view('autors/autors_works_layout', ["title" => "Мои работы", "url" => "/myWorks", "method" => "post", "message" => $message, "subjectAreas" => app(SubjectAreasController::class)->getSubjectAreas(), "showModal" => false]);
    //             //return view('autors/autors_works_layout', ["title" => "Мои работы"], (string)$message);;
    //         } else {
    //             $message = "Файлы не были загружены";
    //             return view('autors/autors_download_layout', (string)$message);
    //             //return view('autors/autors_download_layout', ["title" => "Загрузка работ", "message" => $message]);
    //             //return $message;
    //         }
    //     } else {
    //         $message = "Пожалуйста, заполните пустые поля";
    //         return redirect()->back()->withErrors(['message' => 'Заполните все обязательные поля.']);

    //         // return view('autors/autors_download_layout', ["title" => "Загрузка работы", "url" => "/loadMyWork", "method" => "get", "message" => $message, "subjectAreas" => app(SubjectAreasController::class)->getSubjectAreas(), "showModal" => true]);
    //         //return view('autors/autors_download_layout', ["title" => "Загрузка работ", "message" => $message]);
    //         //return $message;
    //     }
    // }
}
