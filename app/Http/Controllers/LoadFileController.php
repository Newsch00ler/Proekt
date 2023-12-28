<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

            if (!empty($ulpoadFiles)){
                return "$textInput1, $selectValue1, $selectValue2, $textInput2, файл $ulpoadFiles[0] успешно загружен в $destinationPath и файл файл $ulpoadFiles[1] успешно загружен в $destinationPath";
        } else {
            return "Файлы не были загружены";
        }
        } else {
            return "$textInput1, $selectValue1, $selectValue2, $textInput2, Пожалуйста, заполните пустые поля";
        }
    }
}

