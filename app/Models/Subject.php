<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $guarded = [];

    function subject_stu()
    {
        return $this->hasMany('App\Models\Subject_stu', 'subject_id', 'subject_id'); //id คือฟิลของตารางที่จะโยงไป , คีย์ที่จะโยงไป
    }

    function qrcode_att()
    {
        return $this->hasMany('App\Models\Qrcode', 'subject_id', 'subject_id'); //id คือฟิลของตารางที่จะโยงไป , คีย์ที่จะโยงไป
    }

    function branch()
    {
        return $this->hasOne('App\Models\Branch', 'id', 'branch_id');
    }

    function year()
    {
        return $this->hasOne('App\Models\Year', 'id', 'year_id');
    }

    function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'teacher_id');
    }
}
