<?php
/**
 * Created by PhpStorm.
 * User: NnamdiAlexanderAkamu
 * Date: 6/28/2020
 * Time: 11:39 AM
 */

namespace App\Traits\TrainingTraits;


use App\Notifications\TrApproveTrainingPlanNotification;
use App\Notifications\TrTrainingPlanApprovedNotification;
use App\Stage;
use App\TrTrainingPlan;
use App\TrTrainingPlanApprovals;
use App\User;
use App\Workflow;
use Auth;
use Illuminate\Database\Eloquent\Builder;

trait TrainingPlanApprovalTrait
{


	function runApproval(){

		if (!request()->filled('status')){
			return [
				'message'=>'Invalid approval selected!',
				'error'=>true
			];
		}

		if (!request()->filled('id')){
			return [
				'message'=>'Invalid selection!',
				'error'=>true
			];
		}

		$id = request('id');
		$approval = request('status');

		$trainingPlanApproval = TrTrainingPlanApprovals::find($id);

		if (is_null($trainingPlanApproval)){
			return [
				'message'=>'Invalid selection!!',
				'error'=>true,
				'modal'=>'#approval' . $id
			];
		}

		$queryCheck = (new TrTrainingPlanApprovals)->newQuery();
		$queryCheck = $queryCheck->whereHas('training_plan',function(Builder $builder){
			return $builder->whereHas('workflow', function (Builder $builder) {
			   return $builder;
			});
		})->where('id',$id);

		$id = $trainingPlanApproval->training_plan->id;


		if (!$queryCheck->exists()){
			return [
				'message'=>'Workflow altered!!',
				'error'=>true,
				'modal'=>'#approval' . $id
			];
		}



        if ($approval == 2){ //rejected

             $trainingPlanApproval->status = 2;
             $trainingPlanApproval->comments = request('comments');
             $trainingPlanApproval->approver_id = Auth::user()->id;
             $trainingPlanApproval->save();

             $trainingPlanApproval->training_plan->status = 2;
             $trainingPlanApproval->training_plan->save();

//             $trainingPlanApproval->training_plan->created_by->notify();

	        return [
	        	'message'=>'Training Plan Request Rejected!',
		        'error'=>false,
		        'modal'=>'#approval' . $id
	        ];

        }

		$workFlowObject = Workflow::find($trainingPlanApproval->training_plan->workflow->id);
		

        if ($approval == 1){ //approved

	        $trainingPlanApproval->status = 1;
	        $trainingPlanApproval->comments = request('comments');
	        $trainingPlanApproval->approver_id = Auth::user()->id;
	        $trainingPlanApproval->save();

            $newPosition = $trainingPlanApproval->stage->position + 1;
            $nextStage = Stage::where('workflow_id',$workFlowObject->id)->where('position',$newPosition)->first();


            if (is_null($nextStage)){

	            $trainingPlanApproval->training_plan->status = 1;
	            $trainingPlanApproval->training_plan->save();

	            try{
		            $trainingPlanApproval->training_plan->created_by_->notify(new TrTrainingPlanApprovedNotification($trainingPlanApproval->training_plan));
	            }catch (\Exception $exception){
					//
	            }

	            $this->sendNotificationToCadreUsers($trainingPlanApproval->training_plan);

//	            $notifiables = (new TrTrainingPlan)->getNotifiables($workFlowStageObject, $trainingPlanObject);

	            return [
	            	'message'=>'Training Plan Approved Successfully',
		            'error'=>false,
		            'modal'=>'#approval' . $id
	            ];

            }

//            dd($nextStage);


            //training_plan_approvals
	        $newTrainingPlanApproval = new TrTrainingPlanApprovals;

            $newTrainingPlanApproval->stage_id = $nextStage->id;
            $newTrainingPlanApproval->status = 0;
	        $newTrainingPlanApproval->comments = 'Pending...';
	        $newTrainingPlanApproval->approver_id = 0;

            $trainingPlanApproval->training_plan->training_plan_approvals()->save($newTrainingPlanApproval);


	        $notifiables = (new TrTrainingPlan)->getNotifiables($nextStage, $trainingPlanApproval->training_plan);

	        (new TrTrainingPlan)->sendApproveTrainingPlanNotification($notifiables, $trainingPlanApproval->training_plan);

	        $ret = [
		        'message'=>'Training Plan Approved and sent to the next approver',
		        'error'=>false,
		        'modal'=>'#approval' . $id
	        ];

	        return $ret;

        }


        return [
        	'message'=>'Invalid approval action!',
	        'error'=>true,
	        'modal'=>'#approval' . $id
        ];


	}


	function sendNotificationToCadreUsers($trainingPlanObject){

		$cadre_id = $trainingPlanObject->cadre_id;

        $users = User::where('grade_id',$cadre_id)->get();

        foreach ($users as $user){
          try{
	          $user->notify(new TrApproveTrainingPlanNotification($trainingPlanObject));
          }catch (\Exception $exception){
            //
          }
        }

	}

}