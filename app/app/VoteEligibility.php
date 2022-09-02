<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoteEligibility extends Model
{
    //
    protected $table = 'vote_eligibility';
   	protected $fillable = ['ac', 'year','voter_id'];
}
