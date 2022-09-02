<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmpHistory extends Model
{
    //
    protected $fillable = ['user_id', 'organization', 'position', 'start_date', 'end_date'];
}
