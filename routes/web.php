<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\Work;
use App\Models\SubjectArea;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Test1Controller;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SecController;
use App\Http\Controllers\ExpertController;
use App\Http\Controllers\AutorController;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

use App\Http\Middleware\CheckRole;

//тестовые
Route::get('/dsds', function () {
    // сделать адапт для селектов и инпутов
    // предс/секр
    return view('chm_sec/chm_sec_works_layout', // адаптацию надо
    // return view('chm_sec/chm_sec_experts_layout', // адаптацию надо
    // секр
    // return view('sec/sec_add_date_layout', // адаптацию надо
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
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// для председателя и секретаря
Route::middleware([CheckRole::class . ':Председатель,Секретарь'])->group(function () {
    Route::get('/show-works', [SecController::class, 'showWorks'])->name('show.works');
    Route::get('/show-experts', [SecController::class, 'showExperts'])->name('show.experts');
});

//только секретарь
Route::middleware([CheckRole::class . ':Секретарь'])->group(function () {
    Route::get('/meeting', [SecController::class, 'meeting'])->name('meeting');
    Route::post('/save-date', [SecController::class, 'saveDate'])->name('save.date');
    Route::post('/approve-protocol', [SecController::class, 'approveProtocol'])->name('approve.protocol');
    Route::post('/not-approve-protocol', [SecController::class, 'notApproveProtocol'])->name('not.approve.protocol');
    Route::get('/validation-works', [SecController::class, 'valWorks'])->name('validation.works');
    Route::post('/save-validation', [SecController::class, 'saveVal'])->name('save.validation');
});

//для председателя, секретаря и эксперта
Route::middleware([CheckRole::class . ':Председатель,Секретарь,Эксперт'])->group(function () {
    Route::get('/e-show-works', [ExpertController::class, 'showWorks'])->name('e.show.works');
    Route::get('/check-work', [ExpertController::class, 'checkWork'])->name('check.work');
    Route::post('/save-check-work', [ExpertController::class, 'saveCheckWork'])->name('save.check.work');
});

//для всех
Route::middleware([CheckRole::class . ':Председатель,Секретарь,Эксперт,Автор'])->group(function () {
    Route::get('/load-my-work', [AutorController::class, 'showPageLoadMyWork'])->name('load.my.work');
    Route::post('/upload-process', [AutorController::class, 'uploadProcess'])->name('upload.process');
    Route::get('/my-works', [AutorController::class, 'showPageMyWorks'])->name('my.works');
});

//только админ
Route::prefix('admin')->middleware(CheckRole::class . ':Администратор')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/save-date', [AdminController::class, 'saveDate'])->name('admin.save.date');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/save-users', [AdminController::class, 'saveUsers'])->name('admin.save.users');
    Route::get('/works', [AdminController::class, 'works'])->name('admin.works');
    Route::post('/save-works', [AdminController::class, 'saveWorks'])->name('admin.save.works');
    Route::get('/protocols', [AdminController::class, 'protocols'])->name('admin.protocols');
    Route::post('/save-protocols', [AdminController::class, 'saveProtocols'])->name('admin.save.protocols');
    Route::get('/check-works', [AdminController::class, 'checkWorks'])->name('admin.checkWorks');
    Route::post('/save-check-works', [AdminController::class, 'saveCheckWorks'])->name('admin.save.check.works');
    Route::get('/subject-areas', [AdminController::class, 'subjectAreas'])->name('admin.subjectAreas');
    Route::post('/save-subject-areas', [AdminController::class, 'saveSubjectAreas'])->name('admin.save.subject.areas');
});

// пока что оставить
// Route::middleware(['auth'])->group(function () {
//     Route::get('/loadMyWork', [AutorController::class, 'showPageLoadMyWork'])->name('loadMyWork');
//     Route::post('/uploadProcess', [AutorController::class, 'uploadProcess']);
//     Route::get('/seeMyWorks', [AutorController::class, 'showPageMyWorks'])->name('seeMyWorks');
// });






