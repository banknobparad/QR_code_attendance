<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject_stu extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'subject_id',
        'student_id',
        'name',
    ];

    function subject()
    {
        return $this->belongsTo('App\Models\Subject', 'subject_id', 'subject_id');
    }

    function qrcode_all()
    {
        return $this->hasMany('App\Models\Qrcode_all', 'subject_id', 'subject_id');
    }
}
