<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class applicantanswer extends Model
{
    //
	protected $fillable=['user_id','question_id','selectedoption','job_id'];
}
