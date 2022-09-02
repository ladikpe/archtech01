<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class absencerequest extends Model
{
    //
    protected $fillable = ['absencetypes_id','emp_id', 'startdate', 'enddate', 'reason', 'lm_approve','admin_approve', 'board_approve', 'lm_comments','admin_comments', 'board_comments', 'status', 'priority', 'file', 'pay', 'expected_end'];

    public function leaveType(){
    	return $this->belongsTo('App\absencetype','absencetypes_id');
    }
}
