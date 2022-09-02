<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class emp_review extends Model
{
    //
	protected $fillable=['emp_id','emp_rating','reviewer_id','review','reviewername'];

}
