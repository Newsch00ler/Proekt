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
        $filePath = storage_path('date.txt');
        if(File::size($filePath) !== 0){
            $fileDate = File::exists($filePath) ? File::get($filePath) : date('d.m.Y');
            $date1 = new DateTime($fileDate);
            $date2 = new DateTime($fileDate);
            $dateFormatted = $date2->format('d.m.Y');
            $currentDate = new DateTime();
            if ($currentDate->modify('+5 days') < $date1) {
                $isDisabled = false;
                $isVisible = false;
            }
            else {
                $isDisabled = true;
                $isVisible = true;
            }
        }
        else {
            $dateFormatted = '';
            $isDisabled = false;
            $isVisible = false;
        }
        $subjectAreasDB = DB::select('select * from subject_areas');
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
        return view('autors/autors_download_layout', ["title" => "Загрузка работы", "message" => "Пожалуйста, заполните все поля и загрузите все файлы", "subjectAreas" => $subjectAreasDB, 'date' => $dateFormatted, 'isDisabled' => $isDisabled, 'isVisible' => $isVisible, 'url' => $url, 'role' => $role]);
    }

    // отображение работ только авторизованного пользователя
    public function showPageMyWorks() {
        $worksDB = DB::select('select works.name_work,
            STRING_AGG(subject_areas.name_subject_area, \', \') as name_subject_area,
            works.original_percent as original_percent,
            works.created_at as created_at,
            works.final_grade as final_grade,
            works.status as status,
            SPLIT_PART(link_pdf_file, \'\\\', -1) AS file_name
            from works
            inner join autors_works on works.id_work = autors_works.id_work
            inner join works_subject_areas on works.id_work = works_subject_areas.id_work
            inner join subject_areas on works_subject_areas.id_subject_area  = subject_areas.id_subject_area
            where autors_works.id_user = ?
            GROUP BY works.id_work', [Auth::user()->id_user]);
        $countAllWorks = DB::select('select COUNT(*) from works
            inner join autors_works on works.id_work = autors_works.id_work
            where autors_works.id_user = ?', [Auth::user()->id_user]);
        $countAllVerifiedWorks = DB::select('select COUNT(*) from works
            inner join autors_works on works.id_work = autors_works.id_work
            where autors_works.id_user = ? and works.status = \'Внесена в протокол\'', [Auth::user()->id_user]);
        $countAllUnverifiedWorks = DB::select('select COUNT(*) from works
            inner join autors_works on works.id_work = autors_works.id_work
            where autors_works.id_user = ? and (works.status = \'Не подтверждена\' or works.status = \'На проверке\')', [Auth::user()->id_user]);
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
        // dd($worksDB);
        return view('autors/autors_works_layout', ["title" => "Мои работы", "message1" => "Тут надо менять всё", "link" => "/loadPdfFiles/Varianty_k_PR_5.pdf", "worksDB" => $worksDB, "countAllWorks" => $countAllWorks[0]->count, "countAllVerifiedWorks" => $countAllVerifiedWorks[0]->count, "countAllUnverifiedWorks" => $countAllUnverifiedWorks[0]->count, 'url' => $url, 'role' => $role]); //"url" => "/myWorksTest", "method" => "get",
    }

    // главная проблема, что если названия файлов с пробелами или со странной сигнатурой, то вываливаются ошибки (например будет ошибка с меткой 111)
    public function uploadProcess(Request $request){
        $subjectAreasDB = DB::select('select * from subject_areas');
        $subjectAreasArray = json_decode(json_encode($subjectAreasDB), true);
        $worksDB = DB::select('select * from my_works');
        $countAllWorks = DB::select('select COUNT(*) from works');
        $countAllVerifiedWorks = DB::select('select COUNT(*) from works where status = \'Внесена в протокол\'');
        $countAllUnverifiedWorks = DB::select('select COUNT(*) from works where status = \'Не подтверждена\' or status = \'На проверке\'');
        $message = "";
        // 1. Загрузка файла
        $workNameInput = $request->input('nameWork'); //получение значений
        $typeWorkSelect = $request->input('typeWork');
        $subjectAreaSelect = $request->input('subjectAreaWork', []);
        $uploadedFile1Input = $request->file('uploadedFile1');
        $uploadedFile2Input = $request->file('uploadedFile2');
        $uploadedFile3Input = $request->file('uploadedFile4');
        $uploadedFile4Input = $request->file('uploadedFile4');
        $workLinkInput = $request->input('linkWork');
        if ((!empty($workNameInput) && !empty($typeWorkSelect) && !empty($subjectAreaSelect)) &&
        ((!empty($workLinkInput) && !empty($uploadedFile1Input) && !empty($uploadedFile2Input)) ||
        (!empty($uploadedFile3Input) && !empty($uploadedFile4Input)))){ // доп. проверка на пустоту
            $destinationPdfPath = public_path('loadPdfFiles\\'); // для хранения именно pdf
            $destinationTxtPath = public_path('loadTxtFiles\\'); // для хранения именно txt
            $destinationExtractPath = public_path('loadExtractFiles\\'); // для хранения выписок
            $ulpoadFiles = [];
            for ($i = 1; $i < 5; $i++) {
                $fileHtmlName = "uploadedFile$i";

                if ($request->hasFile($fileHtmlName)){
                    $file = $request->file($fileHtmlName); // имя файла в HTML
                    $fileName = $file->getClientOriginalName(); // имя файла с раширением
                    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION); // расширение файла
                    if ($fileExtension == "pdf"){
                        if (file_exists("{$destinationPdfPath}/{$fileName}")) {
                            $message = "Файл с именем {$fileName} уже существует"; // подумать как это выводить, но это работает
                            return redirect()->back();
                        }
                    } else if ($fileExtension == "png" or $fileExtension == "jpg") {
                        if (file_exists("{$destinationExtractPath}/{$fileName}")) {
                            $message = "Файл с именем {$fileName} уже существует.";  // подумать как это выводить, но это работает
                            return redirect()->back();
                        }
                    }
                    $ulpoadFiles[] = $file;
                }
            }

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
                $successConvertPdfToText = $this->convertPdfToText($scriptPath, $pdfFilePath, $txtFilePath);
            }

            if ($successConvertPdfToText === true) {
                $scriptPath = public_path('scripts\TextOriginalityScript.py');
                $check_directory = public_path('test2\\');
                // 3. Вызов Python скрипта для проверки оригинальности
                $successOriginality = $this->checkOriginality($scriptPath, $txtFilePath, $check_directory);
            } else {
                $this->deleteFiles($destinationExtractPath, $ulpoadFiles, $destinationPdfPath, $txtFilePath);
                return redirect()->back();
                trigger_error("Failed to execute Python script", E_USER_ERROR);
            }

            if ($successOriginality['success'] === true) {
                // 4. Сохранение результатов в БД
                if ($typeWorkSelect === "Учебник с грифом" || $typeWorkSelect === "Учебное пособие с грифом") {
                    $signature = "true";
                } else {
                    $signature = "false";
                }
                $successSaveWorkDB = $this->saveResultsToDatabase($workNameInput, "Русский", "false",  $signature, "Не подтверждена", null, null, $successOriginality['percent'], $workLinkInput, $destinationExtractPath . $ulpoadFiles[1]->getClientOriginalName(), $txtFilePath, $pdfFilePath, $subjectAreaSelect);
            } else {
                $this->deleteFiles($destinationExtractPath, $ulpoadFiles, $destinationPdfPath, $txtFilePath);
                return redirect()->back();
                trigger_error("Failed to save results to database", E_USER_ERROR);
            }

            if ($successSaveWorkDB === true) {
                return redirect()->route('my.works');
            } else {
                $this->deleteFiles($destinationExtractPath, $ulpoadFiles, $destinationPdfPath, $txtFilePath);
                return redirect()->back();
                trigger_error("Failed to save results to database", E_USER_ERROR);
            }
        } else {
            return redirect()->back();
        }
    }

    private function convertPdfToText($scriptPath, $pdfFilePath, $txtFilePath){
        $success = false;
        try {
            $command = "py $scriptPath $pdfFilePath $txtFilePath 2>&1";
            exec($command);
            if (filesize($txtFilePath) > 0) { // метка 111
                $success = true;
            }
        } catch (ProcessFailedException $exception) {
            error_log("Ошибка выполнения скрипта Python: {$exception->getMessage()}\n");
        }
        return $success;
    }

    private function checkOriginality($scriptPath, $txtFilePath, $check_directory){
        $success = false;
        try {
            $command = "py $scriptPath $txtFilePath $check_directory 2>&1";
            $percent = exec($command);
            if ($percent !== null) {
                $success = true;
            }
        } catch (ProcessFailedException $exception) {
            error_log("Ошибка выполнения скрипта Python: {$exception->getMessage()}\n");
        }
        return ['percent' => floatval($percent), 'success' => $success];
    }

    private function saveResultsToDatabase($name_work, $language, $creative, $signature, $status, $final_grade, $id_protocol, $original_percent, $link_library, $link_file_extract_protocol, $link_text_file, $link_pdf_file, $subjectAreaSelect){
        $success = false;
        try {
            $newWork = [
                'name_work' => $name_work,
                'language' => $language,
                'creative' => $creative,
                'signature' => $signature,
                'status' => $status,
                'final_grade' => $final_grade,
                'id_protocol' => $id_protocol,
                'original_percent' => $original_percent,
                'created_at' => now(),
                'link_library' => $link_library,
                'link_file_extract_protocol' => $link_file_extract_protocol,
                'link_text_file' => $link_text_file,
                'link_pdf_file' => $link_pdf_file
            ];
            // добавление работы в БД
            $createdWork = DB::table('works')->insert($newWork);
            // добавление связи работы с предметными областями в БД
            $subjectAreaIds = [];
            foreach($subjectAreaSelect as $index => $subjectArea) {
                $resultDB = DB::select('select id_subject_area from subject_areas where name_subject_area = ?', [$subjectArea]);
                foreach ($resultDB as $item) {
                    $subjectAreaIds[] = $item->id_subject_area;
                }
            }
            $maxWorkId = DB::select('select max(id_work) FROM works');
            foreach($subjectAreaIds as $subjectAreaId) {
                $createdWorkSubjectArea = DB::insert('insert into works_subject_areas (id_work, id_subject_area) values (?, ?)', [$maxWorkId[0]->max, $subjectAreaId]);
            }
            // добавление связи работы с пользователем в БД
            $createdUserWork = DB::insert('insert into autors_works (id_user, id_work) values (?, ?)', [Auth::user()->id_user, $maxWorkId[0]->max]);

            if ($createdWork && $createdWorkSubjectArea && $createdUserWork) {
                $success = true;
            }
        } catch (\Exception $e) {
            trigger_error("Failed to save results to database: " . $e->getMessage(), E_USER_ERROR);
        }
        return $success;
    }

    private function deleteFiles($destinationExtractPath, $ulpoadFiles, $destinationPdfPath, $txtFilePath){
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
    }
}
