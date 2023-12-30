<?php

namespace App\Http\Controllers;

use File;
use App\Models\Works;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class WorksController extends Controller
{
    public function FunctionName(){
        $jsonContent = File::json(base_path('storage/worksData.json'));
        $works1 = $jsonContent['works'];
        $works2 = 0;
        $works3 = 0;
        for ($i = 0; $i < count($works1); $i++) {
            $work = $works1[$i];
            $data = [
                'name_work' => $work['name_work'],
                'name_subject_area' => $work['name_subject_area'],
                'original_percent' => $work['original_percent'],
                'download_data' => $work['download_data'],
                'final_grade' => $work['final_grade'],
                'verification_status' => $work['verification_status']
            ];
            if($works1[$i]['verification_status'] == 'Занесена в протокол'){
                $works2++;
            }
            else{
                $works3++;
            }
            $works = Works::create($data);
        }

        $worksDB = DB::select('select * from works');
        return view('autors/autors_works_layout', array("worksDB" => $worksDB), ["title" => "Мои работы", "countWorks" => count($works1), "countWorks2" => $works2, "countWorks3" => $works3]);
        return null;
    }

    public function showWorks(){  //работает нормально
        $worksDB = DB::select('select * from works');
        return view('autors/autors_works_layout', array("worksDB" => $worksDB), ["title" => "Мои работы"]);
    }
    /*public function showWorks(){  //работает нормально
        $jsonContent = File::json(base_path('storage/worksData.json'));
        $works1 = $jsonContent['works'];
        $works2 = 0;
        $works3 = 0;
        for ($i = 0; $i < count($works1); $i++) {
            $work = $works1[$i];
            $data = [
                'name_work' => $work['name_work'],
                'name_subject_area' => $work['name_subject_area'],
                'original_percent' => $work['original_percent'],
                'download_data' => $work['download_data'],
                'final_grade' => $work['final_grade'],
                'verification_status' => $work['verification_status']
            ];
            if($works1[$i]['verification_status'] == 'Занесена в протокол'){
                $works2++;
            }
            else{
                $works3++;
            }
            $works = Works::create($data);
        }

        $worksDB = DB::select('select * from works');
        return view('autors/autors_works_layout', array("worksDB" => $worksDB), ["title" => "Мои работы", "countWorks" => count($works1), "countWorks2" => $works2, "countWorks3" => $works3]);
    }*/

    // public function showWorks1(){
    //     //$jsonContent1 = File::json(base_path('storage/worksData.json')); //тоже работает
    //     $json = Storage::json('storage/worksData.json');
    //     $data = json_decode($json);
    //     $jsonContent = File::json(base_path('storage/worksData.json'));
    //     $works = $jsonContent['works'];
    //     $work1 = $works[0];
    //     $name_work = $work1['name_work'];

    //     $worksDB = DB::select('select * from works');
    //     //dd($worksDB);
    //     // dd($jsonContent);
    //     // dd($jsonContent1);
    //     return view('autors/autors_works_layout', ['works' => $worksDB], ["title" => "Мои работы"]);
    // }
}
