<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class LoadFileController extends Controller
{
    public function upload(Request $request) {
        $message = "";
        $textInput1 = $request->input('workName');
        $selectValue1 = $request->input('typeWork');
        $selectValue2 = $request->input('subAreaWork');
        $textInput2 = $request->input('workLink');

        if (!empty($textInput1) && !empty($selectValue1) && !empty($selectValue2) && !empty($textInput2)){
            $destinationPdfPath = public_path('loadPdfFiles');
            $destinationExtractPath = public_path('loadExtractFiles');
            $ulpoadFiles = [];

            for ($i = 1; $i < 5; $i++) {
                $fileHtmlName = "uploadedFile$i";

                if ($request->hasFile($fileHtmlName)){
                    $file = $request->file($fileHtmlName);
                    $fileName = $file->getClientOriginalName();
                    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

                    if ($fileExtension == "pdf"){
                        if (file_exists("{$destinationPdfPath}/{$fileName}")) {
                            $message = "Файл с именем {$fileName} уже существует в папке.";
                            //return view('autors/autors_download_layout', ["title" => "Загрузка работ", "message" => $message]);
                            //return view('main_layout')->with('message', $output);
                            return $message;
                        }
                    } else if ($fileExtension == "png" or $fileExtension == "jpg") {
                        if (file_exists("{$destinationExtractPath}/{$fileName}")) {
                            $message = "Файл с именем {$fileName} уже существует в папке.";
                            //return view('autors/autors_download_layout', ["title" => "Загрузка работ", "message" => $message]);
                            //return redirect()->route('showPopup', ['message' => "Файл с именем {$fileName} уже существует в папке."]);
                            return $message;
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
                $pythonPath =  realpath('C:\Users\Home\AppData\Local\Programs\Python\Python312\python.exe');
                $scriptPath = public_path('scripts\TranslatePDFtoTXTScript.py');
                $pdfFilePath = public_path('loadPdfFiles/' . $request->file('uploadedFile1')->getClientOriginalName());
                $pdfFileName = substr($request->file('uploadedFile1')->getClientOriginalName(), 0, -4);
                $txtFilePath = public_path("loadTxtFiles/" . $pdfFileName . ".txt");

                $process = new Process([$pythonPath, $scriptPath, $pdfFilePath, $txtFilePath]);
                try {
                    $process->mustRun();

                    if ($process->isSuccessful()) {
                        // Скрипт успешно выполнился
                        $output = $process->getOutput();
                        //return view('main_layout')->with('message', $output);
                        //echo "Скрипт успешно выполнился";
                    } else {
                        // Скрипт завершился с ошибкой
                        $errorOutput = $process->getErrorOutput();
                        error_log("Скрипт не выполнился: {$errorOutput}");
                    }
                    $process->getErrorOutput();
                } catch (ProcessFailedException $exception) {
                    // Процесс не удалось запустить
                    error_log("Ошибка выполнения скрипта Python: {$exception->getMessage()}\n");
                }
            }

            if (!empty($ulpoadFiles) && isset($ulpoadFiles[1])){
                $message = "Наименование: $textInput1<br>
                    Вид работы: $selectValue1<br>
                    Предметная область: $selectValue2<br>
                    Ссылка на выписку из протокола: $textInput2<br>
                    Файл $ulpoadFiles[0] успешно загружен в $destinationPdfPath<br>
                    Файл $ulpoadFiles[1] успешно загружен в $destinationExtractPath";
                //return view('autors/autors_works_layout', ["title" => "Мои работы"]);
                //return view('autors/autors_download_layout', ["title" => "Загрузка работ", "message" => $message]);
                //return $message;
                return view('autors/autors_works_layout', ["title" => "Мои работы"]);;
            } else {
                $message = "Файлы не были загружены";
                //return view('autors/autors_download_layout', ["title" => "Загрузка работ", "message" => $message]);
                return $message;
            }
        } else {
            $message = "Пожалуйста, заполните пустые поля";
            //return view('autors/autors_download_layout', ["title" => "Загрузка работ", "message" => $message]);
            return $message;
        }
    }




    /*public function test(Request $request) {
        $pythonPath =  realpath('C:\Users\Home\AppData\Local\Programs\Python\Python312\python.exe');
        $scriptPath = public_path('scripts\TextOriginalityScript.py');
        $checkText = public_path('test1\er-19101.txt');
        $checkDirectoryPath = public_path('test2');
        //$process = new Process([$pythonPath, $scriptPath, $checkText, $checkDirectoryPath]);
        $process = new Process([$pythonPath, $scriptPath]);
        try {
            $process->mustRun();

            if ($process->isSuccessful()) {
                // Скрипт успешно выполнился
                $output = $process->getOutput();
                $results = file('results.txt', FILE_IGNORE_NEW_LINES);

                // Вывод результатов
                foreach ($results as $result) {
                    echo $result . PHP_EOL;
                }
                //return view('main_layout')->with('message', $output);
                //echo "Скрипт успешно выполнился";
            } else {
                dd('3');
                // Скрипт завершился с ошибкой
                $errorOutput = $process->getErrorOutput();
                error_log("Скрипт не выполнился: {$errorOutput}");
            }
            $process->getErrorOutput();
        } catch (ProcessFailedException $exception) {
            // Процесс не удалось запустить
            dd("Ошибка выполнения скрипта Python: {$exception->getMessage()}\n");
            error_log("Ошибка выполнения скрипта Python: {$exception->getMessage()}\n");
        }
    }*/

    public function test(Request $request) {

        try {
            $pythonPath =  realpath('C:\Users\Home\AppData\Local\Programs\Python\Python312\python.exe');
            $scriptPath = public_path('scripts\TextOriginalityScript.py');
            $command = 'C:\Users\Home\AppData\Local\Programs\Python\Python312\python.exe C:\Users\Home\Desktop\Diplom\Proekt\public\scripts\TextOriginalityScript.py 2>&1';
            $output = shell_exec($command);
            $results = file('C:\Users\Home\Desktop\Diplom\Proekt\public\scripts\results.txt', FILE_IGNORE_NEW_LINES);
            // Вывод результатов
            foreach ($results as $result) {
                echo $result . PHP_EOL;
            }
        } catch (ProcessFailedException $exception) {
            // Процесс не удалось запустить
            dd("Ошибка выполнения скрипта Python: {$exception->getMessage()}\n");
            error_log("Ошибка выполнения скрипта Python: {$exception->getMessage()}\n");
        }
    }
}
