<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\Work;
use App\Models\SubjectArea;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Test1Controller;

use App\Http\Controllers\SubjectAreasController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\WorksController;
use App\Http\Controllers\AutorWorkController;
use Illuminate\Contracts\Filesystem\FileNotFoundException;


//Route::get('/works', [WorksController::class, 'showWorks1']);

Route::get('/expertsWorks', [WorksController::class, 'showWorks']);

// Route::get('/', function () {
//         // $json = File::json(base_path('storage/worksData.json'));
//         // $db = DB::select('select * from works');
//         // dd($json, $db);
//         // $users = DB::select('select * from users');
//         // $subject_areas = DB::select('select * from subject_areas');
//         //$json = File::json(base_path('storage/worksData.json'));
//         //$json = Storage::json('storage/worksData.json');

//         // dd($subject_areas);


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
// Route::get('/loadMyWork',
//     function () {
//         return view('autors/autors_download_layout',
//         ["title" => "Загрузка работ", [SubjectAreasController::class, 'getSubjectAreas']]);
//     }
// );



Route::get('/loadMyWork1', [SubjectAreasController::class, 'getSubjectAreas1']);

Route::get('/myWorks', [AutorWorkController::class, 'uploadProcess']);

// Route::get('/myWorks',
//     [AutorWorkController::class, 'upload']
// );

Route::get('/myWork', [WorksController::class, 'showWorks']);

Route::get('/test',
    // function () {
    //     $db = DB::select('select * from users');
    //     dd($db);
    // },
    [AutorWorkController::class, 'test']
);

//Route::get('/autorWorks', [WorksController::class, 'createWorks']);

Route::get('/login', [LoginController::class, 'showPageLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');;

// ниже три строки как должно быть
Route::middleware(['auth'])->group(function () {
    Route::get('/loadMyWork', [AutorWorkController::class, 'showPageLoadMyWork'])->name('loadMyWork');
    Route::post('/uploadProcess', [AutorWorkController::class, 'uploadProcess']);
    Route::get('/seeMyWorks', [AutorWorkController::class, 'showPageMyWorks'])->name('seeMyWorks');
});

// ниже тестовые три строки
Route::get('/loadMyWorkTest', [TestController::class, 'showForm'])->name('loadMyWorkTest');
Route::post('/myWorksTest', [TestController::class, 'processForm']);
Route::get('/myWorksTest1', [Test1Controller::class, 'showSuccessPage'])->name('myWorksTest1');






