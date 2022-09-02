<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    //
    protected $fillable = ['user_id', 'name', 'course', 'degree', 'degree_class', 'start_year', 'end_year'];
}
