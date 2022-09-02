<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfessionalQualification extends Model
{
    //
     protected $fillable =['name','issue_org','issue_date','exp_date','emp_id'];

    public function user(){
    	return $this->belongsTo('App\User','emp_id');
    }
}
