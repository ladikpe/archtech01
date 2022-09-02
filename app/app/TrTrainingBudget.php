<?php

namespace App;

use App\Traits\TrainingTraits\TrainingBudgetTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TrTrainingBudget extends Model
{
	use TrainingBudgetTrait;
    //
	protected $table = 'tr_training_budget_ferma';

	function cadre(){
		return $this->belongsTo(Cadre::class,'cadre_id');
	}

	function fetch(){
		$query = (new TrTrainingBudget)->newQuery();

		$query = $query->whereHas('cadre',function(Builder $builder){
			return $builder;
		});

		return $query;
	}

}
