<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qrcode_all extends Model
{
    use HasFactory;

    protected $fillable = [
        'qrcode_id',
        'teacher_id',
        'subject_id',
        'student_id',
        'status',
        'check'
        // ฟิลด์อื่น ๆ ที่ต้องการให้สามารถกำหนดค่าผ่านวิธี Mass Assignment
    ];

    // เปิดใช้งานการบันทึกเวลาที่สร้างและอัปเดต
    public $timestamps = true;

    // โค้ดอื่น ๆ ในโมเดล

    function student_substu()
    {
        return $this->belongsTo('App\Models\Subject_stu', 'student_id', 'student_id');
    }

    // ในโมเดล Qrcode_all
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}
