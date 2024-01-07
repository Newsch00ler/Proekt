<?php

namespace App\Http\Controllers;

use App\Models\SubjectArea;
use Illuminate\Http\Request;

class SubjectAreasController extends Controller
{
    public function getSubjectAreas(){
        $subjectAreas = SubjectArea::all();
        return view('autors/autors_download_layout', ["title" => "Загрузка работы", "message" => "", "subjectAreas" => $subjectAreas]);
    }

    public function getSubjectAreas1(){
        $subjectAreas = SubjectArea::all();
        // $formattedSubjectAreas = [];

        // foreach ($subjectAreas as $subjectArea) {
        //     $formattedSubjectAreas[] = ['name_subject_area' => $subjectArea->name_subject_area];
        // }
        return ['subjectAreas' => $subjectAreas];
    }
}
