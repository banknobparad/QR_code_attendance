<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QrcodeCheck;
use App\Models\Subject;
use App\Models\Year;
use App\Models\Branch;

class ReportCheckController extends Controller
{
    public function index(Request $request)
    {

        $subjects = Subject::all();
        $years = Year::all();
        $branchs = Branch::all();
 // รับค่าการค้นหาจาก input fields
 $subjectId = $request->subject_id ?? '';
 $yearId = $request->year_id ?? '';
 $branchId = $request->branch_id ?? '';

 // เริ่มการค้นหาโดยเรียกใช้ query builder ของ QrcodeCheck
 $query = QrcodeCheck::query()->orderByDesc('id');

 // กรองข้อมูลตามเงื่อนไขการค้นหา
 if (!empty($subjectId)) {
     $query->where('subject_id', $subjectId);
 }

 if (!empty($yearId)) {
     $query->where('year_id', $yearId);
 }

 if (!empty($branchId)) {
     $query->where('branch_id', $branchId);
 }


        $data = $query->paginate(15); 
        return view('teacher.report.reportCheck',compact('data','subjects','years','branchs'));
    }
}
