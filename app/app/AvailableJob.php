<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AvailableJob extends Model
{
    //
    protected $fillable = ['title', 'job_desc', 'required_exp', 'job_ref', 'min_sal', 'max_sal', 'min_exp', 'max_exp', 'level_id', 'type_id', 'location_id', 'spec_id', 'qualification', 'date_expire'];
}
