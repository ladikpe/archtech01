<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ratingmodel extends Model
{
    protected $table='ratings';
     protected $fillable = ['emp_id', 'goal_id', 'lm_rate', 'lm_id', 'lm_comment', 'admin_id', 'admin_rate', 'admin_comment', 'quarter', 'emp_comment'];
}
