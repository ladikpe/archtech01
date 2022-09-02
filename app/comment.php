<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $fillable = ['lm_comment', 'emp_comment', 'goal_id', 'user_id','quarter'];
}
