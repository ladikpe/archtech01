<?php

namespace App;

use App\Traits\TrainingTraits\UserTrainingTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Auth;

class TrUserTraining extends Model
{
	use UserTrainingTrait;
    //
	protected $table = 'tr_user_training';




	function fetch(){
		$query = (new TrUserTraining)->newQuery();

		$query = $query->whereHas('training_plan',function (Builder $builder){
			return $builder->whereHas('training_plan_approvals', function (Builder $builder) {
			  return $builder->where('status',1);
			})->where('status',1);
		})->where('user_id',Auth::user()->id);

		return $query;
	}


	function training_plan(){
		return $this->belongsTo(TrTrainingPlan::class,'tr_training_plan_id');
	}




}
