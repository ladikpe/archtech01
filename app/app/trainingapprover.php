<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class trainingapprover extends Model
{
    //
    protected $fillable=['training_type','approval_id','initiator_id','training_id'];
}
