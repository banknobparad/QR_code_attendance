<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qrcode_check extends Model
{
    use HasFactory;
    protected $fillable = [
        'status',
        'check',
        'update_at'
    ];
    function student()
    {
        return $this->belongsTo('App\Models\Subject_stu', 'student_id', 'student_id');
    }
}
