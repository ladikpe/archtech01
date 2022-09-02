<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoteReport extends Model
{
    //
    protected $table = 'votereport';
    protected $fillable = [];


function user(){
	return $this->belongsTo('\App\User', 'voted_for_id');
}

public function voteawards(){
	return $this->belongsTo('App\VoteAwards','award_cat');
}


}


