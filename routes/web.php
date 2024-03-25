<?php

use App\Http\Controllers\Attendance;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\QrcodeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');





Route::get('/student/qrcode/checking/{id}', [QrcodeController::class, 'scan'])->name('qrcode.scan');


Route::group(['prefix' => 'teacher', 'middleware' => ['auth']], function () {
    Route::group(['prefix' => 'subject'], function () {
        
        Route::get('index', [SubjectController::class, 'index'])->name('subject.index');
        Route::get('create', [SubjectController::class, 'create'])->name('subject.create');
        
        Route::get('getSubject', [SubjectController::class, 'getsubject'])->name('subject.get');
        

        Route::post('qrcode/created', [QrcodeController::class, 'store'])->name('qrcode.store');

        Route::get('/report/check', [App\Http\Controllers\ReportCheckController::class, 'index'])->name('report.check.index');
        
        Route::post('subject-stu/import', [SubjectController::class, 'importData'])->name('subject.students.import');
        Route::post('store', [SubjectController::class, 'store'])->name('subject.store');
    });

    Route::group(['prefix' => 'attendance'], function () {
        
        Route::get('index', [AttendanceController::class, 'index'])->name('attendance.index');
    });
});
