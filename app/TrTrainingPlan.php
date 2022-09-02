<?php

namespace App;

use App\Traits\TrainingTraits\TrainingPermissionMigrationTrait;
use App\Traits\TrainingTraits\TrainingPlanTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TrTrainingPlan extends Model
{
	use TrainingPlanTrait;
	use TrainingPermissionMigrationTrait;
    //
	protected $table = 'tr_training_plan';


	function training_plan_approvals(){

		return $this->hasMany(TrTrainingPlanApprovals::class,'tr_training_plan_id');

	}

	function created_by_(){
		return $this->belongsTo(User::class,'created_by');
	}

	function cadre(){
		return $this->belongsTo(Cadre::class,'cadre_id');
	}

	function workflow(){
		return $this->belongsTo(Workflow::class,'workflow_id');
	}

	function fetch(){

		$this->handlePermissionMigration();

		$query = (new TrTrainingPlan)->newQuery();


		$query = $query->whereHas('workflow',function(Builder $builder){
			return $builder;
		});

//		->whereHas('workflow', function (Builder $builder) {
//			return $builder;
//		});

		$query = $query->orderBy('id','desc');


		return $query;
	}


	function user_trainings(){
	    return $this->hasMany(TrUserTraining::class,'tr_training_plan_id');
	}

	function getApprovalStatus(){
		$id = $this->id;

		$query = (new TrTrainingPlanApprovals)->newQuery();
		$query = $query->whereHas('training_plan', function (Builder $builder) use ($id) {
		  return $builder->where('id',$id);
		})->orderBy('id','desc')->first();

//		$query = (new TrTrainingPlan)->newQuery();
//		$query = $query->whereHas('user_trainings', function (Builder $builder) {
//
//			return $builder;
//
//		})->whereHas('training_plan_approvals', function (Builder $builder) {
//
//			return $builder->where('status',1);
//
//		})->where('id',$id);

		if (is_null($query)){
			return 'Invalid';
		}

		if ($query->status == 1){
			return 'Approved';
		}

		if ($query->status == 2){
			return 'Rejected';
		}


		return 'Pending Approval';

	}

	function enrollee(){
		return $this->belongsTo(User::class,'user_id');
	}

	function group(){
		return $this->belongsTo(UserGroup::class,'group_id');
	}


}
