<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class public_holiday extends Model
{
    //
	
	protected $fillable=['title','start_date','end_date'];
}
