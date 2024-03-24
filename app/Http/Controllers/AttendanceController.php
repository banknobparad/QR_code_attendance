<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Year;
use App\Models\Branch;
use App\Models\Qrcode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AttendanceController extends Controller
{
    public function index(){

        $subjects = Subject::all();
        $years = Year::all();
        $branchs = Branch::all();

        $qrcodes = Qrcode::all();
        return view('teacher.attendance.index', compact('subjects','years','branchs','qrcodes'));
    }
}
