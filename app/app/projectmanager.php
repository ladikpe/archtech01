<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class projectmanager extends Model
{
    //
	protected $fillable=['projectid','manager_id','linemanager_id'];
}
