<?php

namespace App\Models;

use App\Events\AttendanceUpdatedEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qrcode extends Model
{
    use HasFactory;

    function qrcode_checks()
    {
        return $this->hasMany('App\Models\Qrcode_check', 'qrcode_id', 'id');
    }
    function qrcode_subject()
    {
        return $this->belongsTo('App\Models\Subject', 'subject_id', 'subject_id');
    }
    function qrcode_student()
    {
        return $this->hasMany('App\Models\Subject_stu', 'subject_id', 'subject_id');
    }

    // public function broadcastAttendanceUpdated()
    // {
    //     event(new AttendanceUpdatedEvent($this->id));
    // }

    function user()
    {
        return $this->hasMany('App\Models\user', 'id', 'teacher_id');
    }


    // public function isExpired(): bool
    // {
    //     return $this->end_time <= now();
    // }
}
