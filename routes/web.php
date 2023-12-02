<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
        return view('login_layout', [

        //return view('autors/autors_download_layout', [
        //return view('autors/autors_works_layout', [

        //return view('chm_sec/chm_sec_works_layout', [
        //return view('chm_sec/chm_sec_experts_layout', [

        //return view('experts/experts_scoring_layout', [
        //return view('experts/experts_works_layout', [

        //return view('sec/sec_add_date_layout', [
        "title" => "Авторизация"
    ]);
});

