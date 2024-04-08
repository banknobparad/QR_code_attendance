<?php

namespace App\Http\Controllers;

use App\Events\AttendanceUpdated;
use App\Models\Qrcode;
use App\Models\Qrcode_all;
use App\Models\Qrcode_check;
use App\Models\Subject;
use App\Models\Subject_stu;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Scheduler;
use Maatwebsite\Excel\Concerns\ToArray;
// use Illuminate\Support\Facades\Scheduler;



class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
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

        // นับจำนวนการเข้าเรียนใหม่หลังการอัปเดต
        $normalCount = Qrcode_check::where('status', 'มา')->count();
        $lateCount = Qrcode_check::where('status', 'มาสาย')->count();
        $absentCount = Qrcode_check::whereIn('status', ['ขาด', 'ลากิจ', 'ลาป่วย'])->count();



        return response()->json([
            'status' => $status,
            'student_id' => $student_id,
            'student_name' => $student_name,
            'normalCount' => $normalCount,
            'lateCount' => $lateCount,
            'absentCount' => $absentCount,
        ]);
    }

    public function updateAttendance()
    {
        // Update attendance counts
        $normalCount = Qrcode_check::where('status', 'มา')->count();
        $lateCount = Qrcode_check::where('status', 'มาสาย')->count();
        $absentCount = Qrcode_check::whereIn('status', ['ขาด', 'ลากิจ', 'ลาป่วย'])->count();

        // Broadcast updated counts
        broadcast(new AttendanceUpdated([
            'normal' => $normalCount,
            'late' => $lateCount,
            'absent' => $absentCount,
        ]));
    }

    public function checkQrCode($qrcode_id)
    {
        $user = auth()->user(); // รับข้อมูลผู้ใช้ที่เข้าสู่ระบบ
        $qrcode = Qrcode::find($qrcode_id);

        // ตรวจสอบว่ามีข้อมูลของ Qrcode และผู้ใช้ที่เข้าสู่ระบบหรือไม่
        if (!$qrcode || !$user) {
            return response()->json(['message' => 'ไม่พบข้อมูล'], 404);
        }

        // ตรวจสอบว่าผู้ใช้ที่เข้าสู่ระบบเป็นนักศึกษาหรือไม่
        if ($user->role != 'Student') {
            return response()->json(['message' => 'คุณไม่มีสิทธิ์เข้าถึง'], 403);
        }

        // ตรวจสอบว่ามีข้อมูลใน qrcode_checks ของนักศึกษาที่เข้าสู่ระบบหรือไม่
        $qrcodeCheck = Qrcode_check::where('student_id', $user->student_id)->first();

        // dd($user);

        // ถ้ามีข้อมูลใน qrcode_checks ของนักศึกษาที่เข้าสู่ระบบ
        if ($qrcodeCheck) {
            // ตรวจสอบเวลา
            $currentTime = Carbon::now();
            $lateTime = Carbon::parse($qrcode->late_time);

            // ตรวจสอบว่าสแกน QR code ก่อนหรือหลังเวลา late_time
            $status = ($currentTime->lte($lateTime)) ? 'มา' : 'มาสาย';

            // ทำการอัปเดตข้อมูลเฉพาะฟิลด์ status ใน table qrcode_checks
            $qrcodeCheck->update([
                'status' => $status,
            ]);

            return response()->json(['message' => 'อัปเดตข้อมูลเรียบร้อย'], 200);
        }

        // ถ้าไม่มีข้อมูลใน qrcode_checks ของนักศึกษาที่เข้าสู่ระบบ
        return response()->json(['message' => 'ไม่พบข้อมูลในระบบ'], 404);
    }
}
