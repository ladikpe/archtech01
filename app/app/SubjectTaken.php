<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubjectTaken extends Model
{
    //
    protected $fillable = ['user_id', 'subject_id', 'grade_id', 'exam_id'];
}
