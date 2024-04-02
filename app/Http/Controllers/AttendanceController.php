<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Subject_stu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AttendanceController extends Controller
{
    public function index(){

        $subjects = Subject::where('teacher_id', Auth::id())->get();

        return view('teacher.attendance.index', compact('subjects'));
    }
}
