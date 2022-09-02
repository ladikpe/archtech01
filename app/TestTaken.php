<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestTaken extends Model
{
    //
	protected $table='test_takens';
	protected $fillable = ['user_id', 'job_id', 'test_taken'];
}
