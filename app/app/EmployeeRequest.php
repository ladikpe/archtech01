<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeRequest extends Model
{
    //
    protected $fillable= ['emp_id','request_id','request_content','a_id','status','reason','file','created_at','updated_at'];

    public function user(){
    	return $this->belongsTo('App\User','emp_id');
    }
    public function type(){
    	return $this->belongsTo('App\RequestType','request_id');
    }

    public function approver(){
    	return $this->belongsTo('App\User','a_id');
    }
}
