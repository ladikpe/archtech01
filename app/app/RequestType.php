<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestType extends Model
{
    //
    protected $filable=['name'];

    public function employeeRequest(){
    	return $this->hasMany('App\EmployeeRequest','request_id');
    }
}
