<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    //
    protected $fillable = ['user_id', 'ref_title', 'ref_name', 'ref_prof', 'ref_addr', 'ref_city', 'ref_state_id', 'ref_country_id', 'ref_email', 'ref_phone'];
}
