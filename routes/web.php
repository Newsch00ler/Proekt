<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SecController;
use App\Http\Controllers\ExpertController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\ErrorController;

use App\Http\Middleware\CheckRole;

// обработка ошибок
Route::middleware(['logout_if_authenticated'])->group(function () {
    Route::get('/404', [ErrorController::class, 'show404'])->name('404');
    Route::get('/500', [ErrorController::class, 'show500'])->name('500');
    Route::get('/503', [ErrorController::class, 'show503'])->name('503');
});

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
    Route::post('/add-files', [AdminController::class, 'addFiles'])->name('admin.add.files');
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
