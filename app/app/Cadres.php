<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cadres extends Model
{
    //
    protected $table = 'cadre_config';
	protected $fillable = ['id',
	 'votecat_id',
	  'cadreid',
	   'percentage'];


	   function VoteName(){
	   	return $this->belongsTo('\App\Vote','votecat_id');
	   }

	   function CadreName(){
	   	return $this->belongsTo('\App\Cadre','cadreid');
	   }
}


