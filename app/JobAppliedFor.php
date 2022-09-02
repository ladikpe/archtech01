<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobAppliedFor extends Model
{
    //
    protected $fillable = ['user_id', 'job_id', 'status'];
}
