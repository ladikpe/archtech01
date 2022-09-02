<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class formdata extends Model
{
    //
    protected $fillable=[ 'formname','formvalue','formid','user_id','quarter'];
}
