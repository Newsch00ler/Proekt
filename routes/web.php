<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\Work;
use App\Models\SubjectArea;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Test1Controller;

// мб удалить use App\Http\Controllers\SubjectAreasController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SecController;
use App\Http\Controllers\ExpertController;
// мб удалить use App\Http\Controllers\WorksController;
use App\Http\Controllers\AutorController;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

//тестовые
Route::get('/', function () {
    // сделать адапт для селектов и инпутов
    // предс/секр
    //return view('chm_sec/chm_sec_works_layout', // адаптацию надо
    // return view('chm_sec/chm_sec_experts_layout', // адаптацию надо
    // секр
    return view('sec/sec_add_date_layout', // адаптацию надо
    // return view('sec/sec_work_verification_layout', // адаптацию надо
    // эксперт
    // return view('experts/experts_scoring_layout', // адаптацию надо
    // return view('experts/experts_works_layout', // адаптацию надо
             ["title" => "тест"]);
});


// по мудл
//Route::get('loginM', 'AuthController@login');


// по БД вход
Route::get('/login', [LoginController::class, 'showPageLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');;


//секретарь
Route::get('/show-works', [SecController::class, 'showWorks'])->name('show.works');
Route::get('/show-experts', [SecController::class, 'showExperts'])->name('show.experts');
Route::get('/add-date', [SecController::class, 'addDate'])->name('add.date');
Route::post('/save-date', [SecController::class, 'saveDate'])->name('save.date');
Route::get('/verification-works', [SecController::class, 'verWorks'])->name('verification.works');


//председатель
Route::get('/show-works', [SecController::class, 'showWorks'])->name('show.works');
Route::get('/show-experts', [SecController::class, 'showExperts'])->name('show.experts');


//эксперт
Route::get('/e-show-works', [ExpertController::class, 'showWorks'])->name('show.works');
Route::get('/check-work', [ExpertController::class, 'checkWork'])->name('check.works');


//автор
Route::get('/load-my-work', [AutorController::class, 'showPageLoadMyWork'])->name('load.my.work');
Route::post('/upload-process', [AutorController::class, 'uploadProcess'])->name('upload.process');
Route::get('/my-works', [AutorController::class, 'showPageMyWorks'])->name('my.works');


// пока что оставить
// Route::middleware(['auth'])->group(function () {
//     Route::get('/loadMyWork', [AutorController::class, 'showPageLoadMyWork'])->name('loadMyWork');
//     Route::post('/uploadProcess', [AutorController::class, 'uploadProcess']);
//     Route::get('/seeMyWorks', [AutorController::class, 'showPageMyWorks'])->name('seeMyWorks');
// });






