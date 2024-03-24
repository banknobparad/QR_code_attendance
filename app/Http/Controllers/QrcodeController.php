<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Qrcode;

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
}
