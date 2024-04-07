<?php

namespace App\Http\Controllers;

use App\Models\Qrcode;
use App\Models\Qrcode_all;
use App\Models\Qrcode_check;
use App\Models\Subject;
use App\Models\Subject_stu;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Scheduler;
// use Illuminate\Support\Facades\Scheduler;



class AttendanceController extends Controller
{
    public function home()
    {
        return view('teacher.attendance.home');
    }
    public function index()
    {

        $subjects = Subject::where('teacher_id', Auth::id())->get();

        return view('teacher.attendance.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([]);

        $inputqrcode = [
            'teacher_id' => auth()->user()->id,
            'subject_id' => $request->subject_id,
            'start_time' => $request->start_time,
            'late_time' => $request->late_time,
            'end_time' => $request->end_time,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        $subjectStus = Subject_stu::where('subject_id', $request->subject_id)->get();
        $user = auth()->user();

        $qrcodeId = Qrcode::insertGetId($inputqrcode);

        // สร้างข้อมูลใหม่ในตาราง qrcode_checks สำหรับแต่ละผู้ใช้ที่มี subject_id เหมือนกับที่เลือก
        foreach ($subjectStus as $subjectStu) {
            $qrcodeCheck = new Qrcode_check;
            $qrcodeCheck->qrcode_id = $qrcodeId;
            $qrcodeCheck->subject_id = $request->subject_id;
            $qrcodeCheck->teacher_id = $user->id;
            $qrcodeCheck->student_id = $subjectStu->student_id;

            $qrcodeCheck->save();
        }

        $this->checkAndStoreQRCodeChecks();

        return redirect()->route('attendance.showQRcode');
    }

    public function showQRcode()
    {
        $qrcodes = Qrcode::with('qrcode_checks.student', 'qrcode_subject')->where('teacher_id', Auth::id())->where('status', '=', 'active')->get();
        // dd($qrcodes->toArray());
        return view('teacher.attendance.show', compact('qrcodes'));
    }

    function checkAndStoreQRCodeChecks()
    {
        $currentTime = Carbon::now(); // เวลาปัจจุบัน


        $qrcodes = QRCode::where('end_time', '<', $currentTime)->get();

        $qrcodes = QRCode::whereDate('created_at', '<', $currentTime)->get();


        foreach ($qrcodes as $qrcode) {
            // ค้นหา qrcode_checks ที่มี qrcode_id ตรงกับ qrcode ที่พบ
            $qrcodeChecks = Qrcode_check::where('qrcode_id', $qrcode->id)->get();

            foreach ($qrcodeChecks as $check) {
                // เก็บข้อมูลจาก qrcode_checks ไปยัง qrcode_alls
                Qrcode_all::insert([
                    'qrcode_id' => $check->qrcode_id,
                    'teacher_id' => $check->teacher_id,
                    'subject_id' => $check->subject_id,
                    'student_id' => $check->student_id,
                    'status' => $check->status,
                    'created_at' => $check->created_at,
                    'updated_at' => $check->updated_at,
                    // เพิ่มคอลัมน์อื่นๆ ตามที่ต้องการ
                ]);

                Qrcode_check::where('id', $check->id)->delete();
            }

            $qrcode->status = 'expired';
            $qrcode->save();
        }
    }

    public function updateStatus(Request $request)
    {
        $id = $request->id;
        $status = $request->status;
        $student_id = $request->student_id;
        $student_name = $request->student_name;

        // ทำการอัปเดตค่า status ใน database
        Qrcode_check::where('id', $id)->update(['status' => $status]);

        return response()->json([
            'status' => $status,
            'student_id' => $student_id,
            'student_name' => $student_name
        ]);
    }

    // public function scan(Request $request, $id)
    // {
    //     $qrCode = QRCode::findOrFail($id);

    //     if ($qrCode->isExpired()) {
    //         return response()->json(['error' => 'QR Code นี้หมดอายุแล้ว'], 400);
    //     }

    //     // อนุญาตให้สแกน QR Code

    // }
}
