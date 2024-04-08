<?php

use App\Http\Controllers\Attendance;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\SubjectController;
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

Route::get('/student/qrcode/checking/{qrcode_id}', [AttendanceController::class, 'checkQrCode'])->name('checkQrCode');

Route::group(['prefix' => 'teacher', 'middleware' => ['auth']], function () {
    Route::group(['prefix' => 'subject'], function () {

        Route::get('index', [SubjectController::class, 'index'])->name('subject.index');
        Route::get('get-students/{subject_id}', [SubjectController::class, 'getStudents'])->name('subject.getStudents');


        Route::get('create', [SubjectController::class, 'create'])->name('subject.create');

        Route::get('getSubject', [SubjectController::class, 'getsubject'])->name('subject.get');

        Route::get('/subjects/{subject_id}', [SubjectController::class, 'show'])->name('subject.show');

        Route::get('/edit/subjects/{subject_id}', [SubjectController::class, 'showedit'])->name('subject.showedit');
        Route::post('/edit/subjects/{subject_id}', [SubjectController::class, 'edit'])->name('subject.edit');

        Route::post('subject-stu/import', [SubjectController::class, 'importData'])->name('subject.students.import');

        Route::post('subject-stu/insert', [SubjectController::class, 'importInsert'])->name('subject.students.insert');
        Route::post('subject-stu/update', [SubjectController::class, 'importUpdate'])->name('subject.students.update');

        Route::get('import_excel/{importID}', [SubjectController::class, 'importDelete'])->name('subject.students.delete');

        Route::post('store', [SubjectController::class, 'store'])->name('subject.store');
        Route::post('subject-stu/update/add', [SubjectController::class, 'updateAdd'])->name('subject.students.updateadd');
        Route::post('subject-stu/update/edit', [SubjectController::class, 'updateedit'])->name('subject.students.updateinedit');

        Route::get('/edit/subject-stu/delete/{id}', [SubjectController::class, 'editDelete'])->name('subject.students.editdelete');
        Route::get('subject-stu/delete/{id}', [SubjectController::class, 'delete'])->name('subject.students.homedelete');
    });

    Route::group(['prefix' => 'attendance'], function () {


        Route::get('home', [AttendanceController::class, 'home'])->name('attendance.home');
        Route::get('index', [AttendanceController::class, 'index'])->name('attendance.index');
        Route::get('showQRcode', [AttendanceController::class, 'showQRcode'])->name('attendance.showQRcode');

        Route::post('qrcode/created', [AttendanceController::class, 'store'])->name('attendance.qrcode.store');



        Route::post('/update-status', [AttendanceController::class, 'updateStatus'])->name('attendance.updateStatus');
    });
});
