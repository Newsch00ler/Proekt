<?php

namespace App\Http\Controllers;

use App\Models\SubjectAreas;
use Illuminate\Http\Request;

class SubjectAreasController extends Controller
{
    public function getSubjectAreas(){
        $subjectAreas = SubjectAreas::all();
        return view('autors/autors_download_layout', ["title" => "Загрузка работы", "url" => "/loadMyWork", "method" => "get", "message" => "", "subjectAreas" => $subjectAreas, "showModal" => false]);
    }

    public function getSubjectAreas1(){
        $subjectAreas = SubjectAreas::all();
        // $formattedSubjectAreas = [];

        // foreach ($subjectAreas as $subjectArea) {
        //     $formattedSubjectAreas[] = ['name_subject_area' => $subjectArea->name_subject_area];
        // }
        return ['subjectAreas' => $subjectAreas];
    }
}
