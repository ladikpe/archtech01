<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Eligibility extends Model
{
   	protected $table = 'vote_eligibility';
   	protected $fillable = ['ac', 'year','voter_id'];
}
