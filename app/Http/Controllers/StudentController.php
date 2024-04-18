<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Qrcode;
use App\Models\Qrcode_all;
use App\Models\Qrcode_check;
use App\Models\Subject;
use App\Models\Subject_stu;
use Carbon\Carbon;
use App\Events\AttendanceUpdated;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
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


            return redirect()->back()->with('success', 'เช็คชื่อสำเร็จ');
        }

        return redirect()->back()->with('error', 'ไม่พบข้อมูลในระบบ');
    }

    public function history()
    {
        $user = Auth::user();
        $student_id = $user->student_id;

        $subject_stu = subject_stu::where('student_id', $student_id)
            ->with(['subject.user', 'qrcode_all' => function ($query) use ($student_id) {
                $query->where('student_id', $student_id);
            }])
            ->get();


        // dd($subject_stu->toArray());
        return view('student.history', compact('subject_stu', 'user'));
    }
}
