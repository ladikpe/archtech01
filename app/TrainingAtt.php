<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainingAtt extends Model
{
    //
    protected $fillable = ['user_id','training_name', 'start_date', 'end_date', 'institution', 'location'];
}
