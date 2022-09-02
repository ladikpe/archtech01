<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class option extends Model
{
    //
	protected $fillable=['question_id','option1','option2','option3','option4','correctoption'];
}
