<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Qrcode;
use App\Models\QrcodeCheck;
use Carbon\Carbon;

class QrcodeController extends Controller
{
    public function store(Request $request)
    {

        // ตรวจสอบและกำหนดค่าที่ได้จากแบบฟอร์ม
        $validatedData = $request->validate([
            'subject_id' => 'required', // ต้องการวิชาที่สอน
            'year_id' => 'required', // ต้องการระดับชั้น
            'branch_id' => 'required', // ต้องการห้อง
            'start_time' => 'required', // ต้องการเวลาเริ่มเช็คชื่อ
            'late_time' => 'required', // ต้องการเวลาเริ่มเช็คเข้าเรียนสาย
            'end_time' => 'required', // ต้องการเวลาปิดการเช็คชื่อ
        ]);

        // สร้างรายการใหม่ในฐานข้อมูล
        $checkin = new Qrcode(); // เปลี่ยน YourModel เป็นชื่อโมเดลที่คุณใช้
        $checkin->subject_id = $request->input('subject_id');
        $checkin->year_id = $request->input('year_id');
        $checkin->branch_id = $request->input('branch_id');
        $checkin->start_time = $request->input('start_time');
        $checkin->late_time = $request->input('late_time');
        $checkin->end_time = $request->input('end_time');
        $checkin->save();

        // ส่งกลับไปยังหน้าแบบฟอร์มด้วยข้อความของคุณ
        return redirect()->back()->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
    
    }

    public function scan($id)
    {
        // ค้นหาข้อมูล Qrcode จาก ID ที่ระบุ
        $qrcode = Qrcode::findOrFail($id);

        // ตรวจสอบว่า Qrcode ถูกสร้างขึ้นโดยใช้ subject_id และ branch_id
        if (!$qrcode->subject_id || !$qrcode->branch_id) {
            return redirect()->back()->with('error', 'Qrcode is not properly configured');
        }

        // ตรวจสอบเวลาเริ่มเช็คชื่อ
        $now = Carbon::now();
        $start_time = Carbon::createFromFormat('H:i', $qrcode->start_time);

        if ($now->lt($start_time)) {
            return redirect()->back()->with('error', 'It is not yet time to check in');
        }

        // ตรวจสอบเวลาเริ่มเช็คเข้าเรียนสาย
        $late_time = Carbon::createFromFormat('H:i', $qrcode->late_time);

        // ตรวจสอบว่าผู้ใช้มาสายหรือไม่
        $status = $now->lt($late_time) ? 'present' : 'late';

        // สร้างการเช็คชื่อใหม่
        $checking = new QrcodeCheck();
        $checking->qrcode_id = $qrcode->id;
        // ใส่ student_id หรือทำการตรวจสอบการเช็คชื่อกับผู้ใช้ที่ล็อกอินอยู่
        $checking->student_id = auth()->user()->id;
        $checking->status = $status; // สถานะจะเป็น "สาย" หากผู้ใช้มาสาย
        $checking->subject_id = $qrcode->subject_id;
        $checking->branch_id = $qrcode->branch_id;
        $checking->save();

        return redirect()->back()->with('success', 'Checking successfully recorded');
    }

}
