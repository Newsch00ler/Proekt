<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class LoadFileController extends Controller
{
   public function upload(Request $request)
   {
       $textInput1 = $request->input('workName');
       $selectValue1 = $request->input('typeWork');
       $selectValue2 = $request->input('subAreaWork');
       $textInput2 = $request->input('workLink');

       if (!empty($textInput1) && !empty($selectValue1) && !empty($selectValue2) && !empty($textInput2)){
           $destinationPath = public_path('uploads');
           $ulpoadFiles = [];

           for ($i = 1; $i < 5; $i++) {
               $fileName = "uploadedFile$i";

               if ($request->hasFile($fileName)){
                  $file = $request->file($fileName);
                  $file->move($destinationPath, $file->getClientOriginalName());
                  $ulpoadFiles[] = $file;
               }
           }

           // Преобразование PDF в TXT с помощью Python скрипта
           if ($request->hasFile('uploadedFile1')) {
               $pdfFilePath = public_path('uploads/' . $request->file('uploadedFile1')->getClientOriginalName());
               $txtFilePath = public_path('uploads/translated.txt');

               $process = new Process(['python', storage_path('Scripts/TranslateScriptPDFtoTXT.py'), $pdfFilePath, $txtFilePath]);

               try {
                $process->mustRun();
             
                if ($process->isSuccessful()) {
                    // Скрипт успешно выполнился
                    $output = $process->getOutput();
                    echo "Скрипт успешно выполнился, вывод:\n{$output}\n";
                } else {
                    // Скрипт завершился с ошибкой
                    $errorOutput = $process->getErrorOutput();
                    echo "Скрипт завершился с ошибкой, вывод ошибки:\n{$errorOutput}\n";
                }
             } catch (ProcessFailedException $exception) {
                // Процесс не удалось запустить
                echo "Ошибка выполнения скрипта Python: {$exception->getMessage()}\n";
             }
           }

           if (!empty($ulpoadFiles) && isset($ulpoadFiles[1])){
            return "$textInput1, $selectValue1, $selectValue2, $textInput2, файл $ulpoadFiles[0] успешно загружен в $destinationPath и файл файл $ulpoadFiles[1] успешно загружен в $destinationPath";
         } else {
            return "Файлы не были загружены";
         }
       } else {
           return "$textInput1, $selectValue1, $selectValue2, $textInput2, Пожалуйста, заполните пустые поля";
       }
   }
}
