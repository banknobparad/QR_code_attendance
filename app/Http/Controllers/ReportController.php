<?php

namespace App\Http\Controllers;

use App\Models\Qrcode;
use App\Models\Qrcode_all;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Exports\AttendanceExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index()
    {

        $subjects = Subject::with(['qrcode_att', 'branch', 'year',])->where('teacher_id', Auth::id())->get();

        // dd($subjects->toArray());
        return view('teacher.reports.index', compact('subjects'));
    }
    public function detail($id)
    {
        $qrcode = Qrcode::with('qrcode_subject')->find($id); // หา Qrcode จาก ID ที่รับมา
        $qrcode_alls = Qrcode_all::with('student_substu')->where('qrcode_id', $qrcode->id)->get(); // หาข้อมูลใน qrcode_alls ที่ qrcode_id ตรงกับ Qrcode ที่ค้นหา

        // dd($qrcode_alls->toArray());


        return view('teacher.reports.detail', compact('qrcode_alls', 'qrcode'));
    }

    public function exportToExcel($id)
    {
        return Excel::download(new AttendanceExport($id), 'attendance.xlsx');
    }
}
