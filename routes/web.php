<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\WorksController;
use App\Http\Controllers\LoadFileController;
use Illuminate\Contracts\Filesystem\FileNotFoundException;


//Route::get('/works', [WorksController::class, 'showWorks1']);

Route::get('/expertsWorks', [WorksController::class, 'showWorks']);

<<<<<<< HEAD
// Route::get('/', function () {
//         // $json = File::json(base_path('storage/worksData.json'));
//         // $db = DB::select('select * from works');
//         // dd($json, $db);
//         // $users = DB::select('select * from users');
//         // $subject_areas = DB::select('select * from subject_areas');
//         //$json = File::json(base_path('storage/worksData.json'));
//         //$json = Storage::json('storage/worksData.json');
=======
Route::get('/', function () {
        // $json = File::json(base_path('storage/worksData.json'));
        // $db = DB::select('select * from works');
        // dd($json, $db);
        // $users = DB::select('select * from users');
        // $subject_areas = DB::select('select * from subject_areas');
        // $json = File::json(base_path('storage/worksData.json'));
        // $json = Storage::json('storage/worksData.json');
>>>>>>> 202d7516400e45d8824417ddc4d51ea2b69cb098

//         // dd($subject_areas);


<<<<<<< HEAD
//         //return view('login_layout', [

//         return view('autors/autors_download_layout',
//             ["title" => "Авторизация"]);
//         //return view('autors/autors_works_layout', [

//         //return view('chm_sec/chm_sec_works_layout', [
//         //return view('chm_sec/chm_sec_experts_layout', [

//         //return view('sec/sec_add_date_layout', [
//         //return view('sec/sec_work_verification_layout', [

//         //return view('experts/experts_scoring_layout', [
//         //return view('experts/experts_works_layout', [
// });
Route::get('/loadMyWork',
    function () {
        return view('autors/autors_download_layout',
        ["title" => "Авторизация"]);
    }
);

Route::post('/myWorks',
    [LoadFileController::class, 'upload']
);
=======
        // return view('login_layout', [

        return view('autors/autors_download_layout', ["title" => "Авторизация"], [Uploads::class]);
        // return view('autors/autors_works_layout', [

        // return view('chm_sec/chm_sec_works_layout', [
        // return view('chm_sec/chm_sec_experts_layout', [

        // return view('sec/sec_add_date_layout', [
        // return view('sec/sec_work_verification_layout', [

        // return view('experts/experts_scoring_layout', [
        // return view('experts/experts_works_layout', [
>>>>>>> 202d7516400e45d8824417ddc4d51ea2b69cb098

//Route::get('/autorWorks', [WorksController::class, 'createWorks']);


