<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class daily_attendance extends Model
{
    //
	protected $table="daily_attendance";
	protected $fillable=["emp_id","emp_num","date","clock_in","clock_out","flag","daily_deduction_percentage","late_time"];
}
