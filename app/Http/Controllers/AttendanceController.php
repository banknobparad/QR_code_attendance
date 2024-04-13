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
use Illuminate\Support\Facades\Log;
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

            $qrcodeCheck->updated_at = null;

            $qrcodeCheck->save();
        }

        $this->checkAndStoreQRCodeChecks();

        return redirect()->route('attendance.showQRcode');
    }

    public function showQRcode()
    {
        $qrcodes = Qrcode::with('qrcode_checks.student', 'qrcode_subject', 'user')->where('teacher_id', Auth::id())->where('status', '=', 'active')->get();
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


    public function checkQrCode($qrcode_id)
    {
        $user = auth()->user(); // รับข้อมูลผู้ใช้ที่เข้าสู่ระบบ
        $qrcode = Qrcode::find($qrcode_id);

        // ตรวจสอบว่ามีข้อมูลของ Qrcode และผู้ใช้ที่เข้าสู่ระบบหรือไม่
        if (!$qrcode || !$user) {
            return redirect()->back()->with('warning', 'ไม่สามารถสแกน QR code ได้เนื่องจากไม่พบข้อมูล QR code');
        }

        // ตรวจสอบว่าผู้ใช้ที่เข้าสู่ระบบเป็นนักศึกษาหรือไม่
        if ($user->role != 'Student') {
            return redirect()->back()->with('question', 'ไม่สามารถสแกน QR code ได้เนื่องจากคุณไม่ได้เป็นนักศึกษา');
        }


        // ตรวจสอบว่ามีข้อมูลใน qrcode_checks ของนักศึกษาที่เข้าสู่ระบบหรือไม่
        $qrcodeCheck = Qrcode_check::where('student_id', $user->student_id)->first();

        // dd($user);

        if ($qrcodeCheck) {
            // ตรวจสอบค่าในฟิลด์ check
            if ($qrcodeCheck->check == 1) {
                return redirect()->back()->with('question', 'ไม่สามารถสแกน QR code ได้เนื่องจากคุณได้ทำการเช็คชื่อไปแล้ว');
            }
            // ตรวจสอบเวลา
            $currentTime = Carbon::now();
            $lateTime = Carbon::parse($qrcode->late_time);
            $endTime = Carbon::parse($qrcode->end_time);

            // ตรวจสอบว่าสแกน QR code ก่อนหรือหลังเวลา end_time
            if ($currentTime->gt($endTime)) {
                return redirect()->back()->with('error', 'ไม่สามารถเช็คชื่อได้ เนื่องจากเวลาสแกน QR code เกินเวลาที่กำหนด');
            }

            $status = ($currentTime->lte($lateTime)) ? 'มา' : 'มาสาย';

            // ทำการอัปเดตข้อมูลเฉพาะฟิลด์ status ใน table qrcode_checks
            $qrcodeCheck->update([
                'status' => $status,
                'check' => 1,
                'updated_at' => $currentTime
            ]);

            // Update attendance counts
            $normalCount = Qrcode_check::where('status', 'มา')->count();
            $lateCount = Qrcode_check::where('status', 'มาสาย')->count();
            $absentCount = Qrcode_check::whereIn('status', ['ขาด', 'ลากิจ', 'ลาป่วย'])->count();

            // Broadcast updated counts
            broadcast(new AttendanceUpdated([
                'normal' => $normalCount,
                'late' => $lateCount,
                'absent' => $absentCount,
                'status' => [
                    'id' => $qrcodeCheck->id, // เพิ่ม ID ของ status
                    'status' => $status,
                ],
            ]));

            // Log::info('Broadcasted AttendanceUpdated event: ' . json_encode([
            //     'normal' => $normalCount,
            //     'late' => $lateCount,
            //     'absent' => $absentCount,
            //     'status' => [
            //         'id' => $qrcodeCheck->id, // เพิ่ม ID ของ status
            //         'status' => $status,
            //     ],
            // ], JSON_UNESCAPED_UNICODE));


            return redirect()->back()->with('success', 'อัปเดตข้อมูลเรียบร้อย');
        }

        // ถ้าไม่มีข้อมูลใน qrcode_checks ของนักศึกษาที่เข้าสู่ระบบ
        return redirect()->back()->with('error', 'ไม่พบข้อมูลในระบบ');
    }

    public function saveAttendance(Request $request)
    {
        $qrcodeId = $request->input('qrcode_id');
        $qrcode = QRCode::find($qrcodeId);

        if (!$qrcode) {
            // ไม่พบ QR code ที่มี ID ตรงกับที่รับเข้ามา
            // สามารถจัดการตามความเหมาะสม เช่น ส่งข้อความผิดพลาดกลับหรือทำอื่นๆ
            return response()->json(['error' => 'QR code not found'], 404);
        }

        // นำข้อมูลจาก QR code ที่มี ID เดียวกันไปเก็บที่ table qrcode_alls
        // นำข้อมูลจาก QR code ที่มี ID เดียวกันไปเก็บที่ table qrcode_alls
        foreach ($qrcode->qrcode_checks as $check) {
            // สร้างข้อมูลใหม่ในตาราง qrcode_alls โดยกำหนดค่าจากข้อมูลในตาราง qrcode_checks
            $qrcode_all = new Qrcode_all();

            // กำหนดค่าของแต่ละฟิลด์ในตาราง qrcode_alls เท่ากับค่าในตาราง qrcode_checks
            $qrcode_all->qrcode_id = $check->qrcode_id;
            $qrcode_all->teacher_id = $check->teacher_id;
            $qrcode_all->subject_id = $check->subject_id;
            $qrcode_all->student_id = $check->student_id;
            $qrcode_all->status = $check->status;
            $qrcode_all->check = $check->check;
            $qrcode_all->created_at = $check->created_at;
            $qrcode_all->updated_at = $check->updated_at;

            // บันทึกข้อมูลในตาราง qrcode_alls
            $qrcode_all->save();

            // ลบข้อมูลที่มี ID เดียวกันที่ table qrcode_checks
            $check->delete();
        }



        // ทำการอัพเดทสถานะของ QR code เป็น 'expired'
        $qrcode->status = 'expired';
        $qrcode->save();

        // สามารถส่งคืนข้อความหรือสถานะการทำงานอื่นๆ กลับไปยัง client ตามความเหมาะสม
        return redirect()->back()->with('success', 'อัปเดตข้อมูลเรียบร้อย');
    }
}
