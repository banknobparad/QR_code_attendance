<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $guarded = [];

    function subject_stu(){
        return $this->hasMany( 'App\Models\Subject_stu', 'subject_id', 'subject_id' );//id คือฟิลของตารางที่จะโยงไป , คีย์ที่จะโยงไป
    }
}
