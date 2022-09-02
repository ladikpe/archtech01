<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubjectGrade extends Model
{
    //
    protected $fillable = ['grade','remark', 'start_per', 'end_per'];
}
