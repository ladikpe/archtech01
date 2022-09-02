<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class emp_past_emp extends Model
{
    //
	protected $dates=['from','to'];
	protected $fillable=['organization','role','emp_id','from','to'];
 
}
