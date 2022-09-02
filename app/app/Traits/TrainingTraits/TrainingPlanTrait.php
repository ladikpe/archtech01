<?php


namespace App\Traits\TrainingTraits;



use App\Cadre;
use App\CompanyOrganogram;

use App\Grade;
use App\Notifications\ApproveTrainingPlanRequestNotification;
use App\Rank;
use App\Stage;
use App\TrTrainingPlan;
use App\TrTrainingPlanApprovals;
use App\TrTrainingSettings;
use App\TrUserTraining;
use App\User;
use App\Workflow;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Auth;

trait TrainingPlanTrait{


	function createTrainingPlan(){

//	 $workflowSettingName = (new TrTrainingSettings)->getSetting('workfow_name');
//
//	 if (is_null($workflowSettingName)){
//		 return [
//			 'message'=>'Please contact admin to correct training settings (workfow_name not defined)!',
//			 'error'=>true,
//			 'modal'=>'#create-plan'
//		 ];
//	 }
//
//     $workflow_name = $workflowSettingName;
//     if (!(new Workflow)->newQuery()->where('name',$workflow_name)->whereHas('stages',function (Builder $builder){
//     	return $builder;
//     })->exists()){
//     	return [
//     		'message'=>'Invalid work-flow selected!',
//	        'error'=>true,
//	        'modal'=>'#create-plan'
//        ];
//     }




     if (!request()->filled('name_of_training')){
	     return [
		     'message'=>'Please type in a training name!',
		     'error'=>true,
		     'modal'=>'#create-plan'
	     ];
     }

//     $workflowObject = Workflow::find($workflow_id)->stages->first();

	  $workflow_id = request('workflow_id');
	  $workflowInput = (new Workflow)->newQuery()->where('id',$workflow_id)->first();
      $workflowObject = $workflowInput->stages->first();

	  $obj = new TrTrainingPlan;

      $obj->year_of_training = date('Y');
      $obj->name_of_training = request('name_of_training');
      $obj->number_of_participants = request('number_of_participants');
      $obj->workflow_id = $workflowInput->id; // request('workflow_id');
      $obj->cadre_id = request('cadre_id');
      $obj->cost_per_head = request('cost_per_head');
      $obj->total_cost = request('total_cost');
      $obj->created_by = Auth::user()->id;

//      $obj->empower_user_id = request('empower_user_id');
		//group_type

	  $obj->type = request('type');

//      dd(request('empower_user_id'));

		if (request()->filled('empower_user_id'))
			$obj->empower_user_id = implode(',', request('empower_user_id'));

		if (request()->filled('group_id'))
			$obj->group_id = request('group_id');

		if (request()->filled('group_type'))
			$obj->group_type = request('group_type');

      $obj->save();

      $this->createUserTraining($obj->id);

	  $trainingPlanObject = $obj;
	  $notifiables = $this->getNotifiables($workflowObject, $trainingPlanObject);


      //handle workflow
      //training_plan_approvals

		$objApproval = new TrTrainingPlanApprovals;

		if ($workflowObject->type == 1){

		  $objApproval->tr_training_plan_id = $obj->id;
          $objApproval->stage_id = $workflowObject->id;
          $objApproval->comments = '';
          $objApproval->status = 0;
          $objApproval->approver_id = $workflowObject->user_id;

          $obj->training_plan_approvals()->save($objApproval);


		  $this->sendApproveTrainingPlanNotification($notifiables, $trainingPlanObject);

          return [
          	'message'=>'Training Plan created successfully and waiting for user approval',
	        'error'=>false
          ];

		}


//		$notifiables = [];
		if ($workflowObject->type == 2){

			$objApproval->tr_training_plan_id = $obj->id;
			$objApproval->stage_id = $workflowObject->id;
			$objApproval->comments = '';
			$objApproval->status = 0;
			$objApproval->approver_id = 0;

			$obj->training_plan_approvals()->save($objApproval);

		}


        $this->sendApproveTrainingPlanNotification($notifiables, $trainingPlanObject);

	    return [
			'message'=>'Training Plan created successfully and waiting for general approval',
			'error'=>false
		];

	}

	function sendApproveTrainingPlanNotification($list,$trainingPlanObject){
		foreach ($list as $notifiable){
			try{
				$notifiable->notify(new ApproveTrainingPlanRequestNotification($trainingPlanObject));
			}catch (\Exception $exception){
				//
			}
		}

	}

	function getNotifiables($workFlowStageObject,$trainingPlanObject){

		$notifiables = [];

		if ($workFlowStageObject->type == 1){

			if ($workFlowStageObject->user){
				$notifiables[] = $workFlowStageObject->user;
			}

		}

		if ($workFlowStageObject->type == 2){

			if ($workFlowStageObject->role->manages == 'dr'){
				if ($trainingPlanObject->created_by->managers){
					$list = $trainingPlanObject->created_by->managers;
					foreach ($list as $item){
						$notifiables[] = $item;
					}
				}
			}

			if ($workFlowStageObject->role->manages == 'all' || $workFlowStageObject->role->manages == 'none'){
				$list = $workFlowStageObject->role->users;
				foreach ($list as $item){
					$notifiables[] = $item;
				}
			}

		}


		if ($workFlowStageObject->type == 3){
			if ($workFlowStageObject->group){
				$list = $workFlowStageObject->group->users;
				foreach ($list as $item){
					$notifiables[] = $item;
				}
			}
		}


		return $notifiables;

	}


	function createUserTraining($tr_training_plan_id){

	   $trainingPlan = TrTrainingPlan::find($tr_training_plan_id);
	   if (is_null($trainingPlan)){
	   	 return;
	   }

       if ($trainingPlan->type == 'empowerment'){

	       if (!request()->filled('group_type')){
	       	return;
	       }
	       
	       if (request('group_type') == 'group'){

	       	$group_id = request('group_id');

	       	$groupQuery = (new User)->newQuery();

            $groupQuery = $groupQuery->whereHas('user_groups',function(Builder $builder) use ($group_id){
            	return $builder->where('user_groups.id',$group_id);
            });

            $collection = $groupQuery->get();

		       foreach ($collection as $user){
			       $obj = new TrUserTraining;
			       $obj->user_id = $user->id;
			       $obj->tr_training_plan_id = $tr_training_plan_id;
			       $obj->feedback = 'Your Feedback...';
			       $obj->rating = 5;
			       $obj->save();
		       }


	       	return;

	       }


	       if (request('group_type') == 'user'){

	       	   $users = request('empower_user_id');
	       	   foreach ($users as $userId){
		           $obj = new TrUserTraining;
		           $obj->user_id = $userId;
		           $obj->tr_training_plan_id = $tr_training_plan_id;
		           $obj->feedback = 'Your Feedback...';
		           $obj->rating = 5;
		           $obj->save();
	           }

		       return;

	       }


	       if (request('group_type') == 'cadre'){

		       $cadre_id = $trainingPlan->cadre_id;
		       $cadre = Cadre::find($cadre_id);
		       if (is_null($cadre)){
			       return;
		       }


		       $users = $cadre->users;

		       foreach ($users as $k=>$v){

			       $obj = new TrUserTraining;

			       $obj->user_id = $v->id;
			       $obj->tr_training_plan_id = $tr_training_plan_id;
			       $obj->feedback = 'Your Feedback...';
			       $obj->rating = 5;
			       $obj->save();

		       }

		       return;

	       }

       }


		$cadre_id = $trainingPlan->cadre_id;
		$cadre = Cadre::find($cadre_id);
		if (is_null($cadre)){
			return;
		}


		if ($trainingPlan->type == 'group'){

	       $users = $cadre->users;

	       foreach ($users as $k=>$v){

		       $obj = new TrUserTraining;

		       $obj->user_id = $v->id;
		       $obj->tr_training_plan_id = $tr_training_plan_id;
		       $obj->feedback = 'Your Feedback...';
		       $obj->rating = 5;
		       $obj->save();

	       }

       }

	}



	function updateTrainingPlan(){


		$query = (new TrTrainingPlan)->newQuery();
		$query = $query->whereHas('user_trainings', function (Builder $builder) {

			return $builder;

		})->whereHas('training_plan_approvals', function (Builder $builder) {

			return $builder->where('status',1);

		})->where('id',request('id'));


		if ($query->exists()){
			return [
				'message'=>'Training failed to update. This training has already been approved by the SYSTEM ADMIN!',
				'error'=>true
			];
		}


//		$workflow_id = request('workflow_id');
//		if (!(new Workflow)->newQuery()->where('id',$workflow_id)->exists()){
//			return [
//				'message'=>'Invalid work-flow selected!',
//				'error'=>true
//			];
//		}

//		$workflowObject = Workflow::find($workflow_id);

		$obj = TrTrainingPlan::find(request('id'));

//		$obj->year_of_training = date('Y');
		$obj->name_of_training = request('name_of_training');
		$obj->number_of_participants = request('number_of_participants');
//		$obj->workflow_id = request('workflow_id');
		$obj->cadre_id = request('cadre_id');
		$obj->cost_per_head = request('cost_per_head');
		$obj->total_cost = request('total_cost');
//		$obj->empower_user_id = implode(',', request('empower_user_id'));
		$obj->type = request('type');
//		$obj->group_id = request('group_id');

//		$obj->group_type = request('group_type');


		if (request()->filled('empower_user_id'))
			$obj->empower_user_id = implode(',', request('empower_user_id'));

		if (request()->filled('group_id'))
			$obj->group_id = request('group_id');

		if (request()->filled('group_type'))
			$obj->group_type = request('group_type');


//		$obj->created_by = Auth::user()->id;

		$obj->save();


		return [
			'message'=>'Training Plan updated',
			'error'=>false
		];

	}

	function removeTrainingPlan(){

		//user_trainings


		$query = (new TrTrainingPlan)->newQuery();
		$query = $query->whereHas('user_trainings', function (Builder $builder) {

			return $builder;

		})->whereHas('training_plan_approvals', function (Builder $builder) {

			return $builder->where('status',1);

		})->where('id',request('id'));


		if ($query->exists()){
			return [
				'message'=>'Failed to delete. This training has already been approved by the SYSTEM ADMIN!',
				'error'=>true
			];
		}


		$obj = TrTrainingPlan::find(request('id'));

		$obj->delete();

		return [
			'message'=>'Training Plan removed',
			'error'=>false
		];

	}

	function iswithinBudget(){
		$cadre_id = $this->cadre_id;
		$total_cost = $this->total_cost;
		$year = $this->year_of_training;

		$query = (new TrTrainingPlan)->newQuery();
		$query = $query
			     ->where('year_of_training',$year)
			     ->where('cadre_id',$cadre_id)
			     ->whereHas('cadre',function(Builder $builder) use ($total_cost,$year){
          return $builder->whereHas('budget',function(Builder $builder) use ($total_cost,$year){
          	return $builder->where('total_amount','>',$total_cost)->where('year',$year);
          });
		});

		return $query->exists();
	}



	function getSelectedUsers(){
		$list = $this->empower_user_id;
		$list = explode(',', $list);
		$list = array_map(function ($item) {
			$user = User::find($item);

			if (is_null($user)){
				return [
					'id'=>0,
					'name'=>'Removed'
				];
			}

			return [
				'id'=>$user->id,
				'name'=>$user->name
			];
		}, $list);

		return $list;
	}


	function getCurrentStage(){
		$id = $this->id;
		$query = (new Stage)->newQuery();
		$query = $query->whereHas('training_plan_approvals',function(Builder $builder) use ($id){
			return $builder->whereHas('training_plan',function(Builder $builder) use ($id){
				return $builder->where('id',$id);
			});
		})->orderBy('id','desc');

//		$query = $query->whereHas('workflow', function (Builder $builder) use ($id) {
//		 return $builder->whereHas('training_plans',function(Builder $builder) use ($id){
//		 	return $builder->where('id',$id);
//		 });
//		})->orderBy('id','desc');

		$collection = $query->get();

//		dd($collection);

		$query = $query->first();

		if (is_null($query)){
			return 'No-Active Stage';
		}

		return $query->name;
		//training_plan_approvals
	}



	function getCadreUsers(){
		$cadre_id = request('id');
		$cadre = Cadre::find($cadre_id);
		if (is_null($cadre)){
			return [
				'data'=>[]
			];
		}
		return [
			'data'=>$cadre->users
		];

	}

	function getGroupUsers(){
		$group_id = request('id');
//		$group_id = request('group_id');

		$groupQuery = (new User)->newQuery();

		$groupQuery = $groupQuery->whereHas('user_groups',function(Builder $builder) use ($group_id){
			return $builder->where('user_groups.id',$group_id);
		});

		$collection = $groupQuery->get();
		return [
			'data'=>$collection
		];

	}




}
