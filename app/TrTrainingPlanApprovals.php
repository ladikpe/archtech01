<?php

namespace App;

use App\Traits\TrainingTraits\TrainingPlanApprovalTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TrTrainingPlanApprovals extends Model
{

	use TrainingPlanApprovalTrait;

    //
	protected $table = 'tr_training_plan_approvals';

	function training_plan(){
		return $this->belongsTo(TrTrainingPlan::class,'tr_training_plan_id');
	}

	function stage(){
		return $this->belongsTo(Stage::class,'stage_id');
	}


	function fetch(){
		$query = (new TrTrainingPlanApprovals)->newQuery();

		$query = $query->whereHas('training_plan',function(Builder $builder){

			return $builder->whereHas('workflow', function (Builder $builder) {

				return $builder;

			});

//			->whereHas('cadre', function (Builder $builder) {
//
//				return $builder;
//
//			})

		})->whereHas('stage', function (Builder $builder) {

			return $builder;

		});

		$query = $query->orderBy('id','DESC');

		return $query;
	}

	function approved_by(){
		return $this->belongsTo(User::class,'approver_id');
	}

	function getApprovedBy(){
		if ($this->approved_by){
			return $this->approved_by->name;
		}else{
			return 'N/A';
		}
	}
	
	function canBeApprovedBy($user){
		$id = $this->id;
		$query = (new TrTrainingPlanApprovals)->newQuery();
		$query = $query->where('id',$id)->whereHas('stage', function (Builder $builder) use ($user){
		   
			return $builder->where('user_id',$user->id)->orWhere('role_id',$user->role_id)
				->orWhereHas('group', function (Builder $builder) use ($user) {
				   return $builder->whereHas('users',function(Builder $builder) use ($user){
				   	 return $builder->where('user_group_user.user_id',$user->id);
				   });
				});
			
		});
		
		return $query->exists();
	}


	function getRequiresApprovalIdentity(){

		$type = $this->stage->type;

		$stage = $this->stage;
		$user_id = $this->stage->user_id;
		$role_id = $this->stage->role_id;
		$group_id = $this->stage->group_id;

		$typeDict = [
		  	1=>function() use ($user_id){
			  return User::find($user_id)->name;
		    }, //user
			2=>function() use ($role_id){
			  return Role::find($role_id)->name;
			},//role
			3=>function() use ($group_id){
			  return UserGroup::find($group_id)->name;
			}//group
		];

		if (isset($typeDict[$type])){
			return $typeDict[$type]();
		}

		return 'N/A';

	}

	

}
