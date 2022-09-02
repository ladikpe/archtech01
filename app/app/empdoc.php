<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class empdoc extends Model
{
    //
	protected $fillable=['documentname','folder_id','user_id','path','expiry'];
}
