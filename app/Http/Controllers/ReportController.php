<?php

namespace App\Http\Controllers;

use App\Models\Qrcode;
use App\Models\Qrcode_all;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Exports\AttendanceExportDetail;
use App\Exports\AttendancExportAll;
use App\Models\Subject_stu;
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

    public function detailAll($id)
    {
        $subject = Subject::find($id);

        $subject_id = $subject->subject_id;

        // ดึงข้อมูลนักศึกษาที่เข้าเรียนในวิชานี้
        $subject_stu = Subject::where('subject_id', $subject_id)->with(['subject_stu'])->get();

        // ดึงข้อมูล Qrcode ที่เกี่ยวข้องกับวิชานี้พร้อมกับข้อมูลของแต่ละ Qrcode
        $qrcodes = Qrcode::where('subject_id', $subject_id)
            ->with(['qrcode_all' => function ($query) {
                $query->orderBy('created_at', 'asc');
            }])
            ->get();

        // เก็บข้อมูลจำนวนของแต่ละค่าของฟิลด์ status ของแต่ละคน
        $individualStatusCounts = [];

        foreach ($qrcodes as $qrcode) {
            foreach ($qrcode->qrcode_all as $qrcodeData) {
                $status = $qrcodeData['status'];
                $studentId = $qrcodeData['student_id'];

                if (!isset($individualStatusCounts[$studentId])) {
                    $individualStatusCounts[$studentId] = [];
                }

                if (!isset($individualStatusCounts[$studentId][$status])) {
                    $individualStatusCounts[$studentId][$status] = 0;
                }

                $individualStatusCounts[$studentId][$status]++;

                // สืบค้นข้อมูลชื่อจากตาราง subject_stu
                $studentName = Subject_stu::where('student_id', $studentId)->pluck('name')->first();

                // เพิ่มชื่อของนักเรียนลงในข้อมูลที่มีอยู่
                $individualStatusCounts[$studentId]['name'] = $studentName;
            }
        }

        // dd($individualStatusCounts);
        // dd($subject_stu->toArray());

        return view('teacher.reports.detail_all', compact('qrcodes', 'subject', 'subject_stu', 'individualStatusCounts'));
    }



    public function exportToExcel($id)
    {
        return Excel::download(new AttendanceExportDetail($id), 'attendance.xlsx');
    }

    public function exportToExcelAll($id)
    {
        return Excel::download(new AttendancExportAll($id), 'attendanceAll.xlsx');
    }
}
