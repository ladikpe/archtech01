<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveRequestRecall extends Model
{
    protected $fillable=['leave_request_id','recaller_id','recall_reason','old_date','new_date'];

    public function leave_request(){
        return $this->belongsTo('App\LeaveRequest','leave_request_id');
    }
    public function recaller(){
        return $this->belongsTo('App\User','recaller_id');
    }
}
