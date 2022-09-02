<?php

namespace App\Http\Controllers;

use App\Cadre;
use App\Traits\TrainingTraits\FrontControllerTrait;
use App\TrTrainingBudget;
use App\TrTrainingPlan;
use App\TrTrainingPlanApprovals;
use App\TrTrainingSettings;
use App\TrUserTraining;
use App\UserGroup;
use App\Workflow;
use Illuminate\Http\Request;

class TrainingFrontController extends Controller
{
    //

	use FrontControllerTrait;


	function fetchBudget(){
      $data = [];
      $data['cadres'] = Cadre::all();
      $data['list'] = (new TrTrainingBudget)->fetch()->paginate(20);
//      dd($data);
      return view('ferma_training.budget.index',$data);

	}

	function fetchTrainingPlan(){

		return $this->fetchReusableTrainingPlan(false);
//		$data = [];
//		$data['cadres'] = Cadre::all();
//		$data['workflows'] = Workflow::where('status',1)->get();
//		$data['groups'] = UserGroup::where('company_id',companyId())->get();
//		$data['list'] = (new TrTrainingPlan)->fetch()->paginate(20);
//		$data['budget'] = $this->fetchBudget()->render();
//		$data['approval'] = false;
//		if (request()->filled('approval'))
//			 $data['approval'] = true;
//		dd($data);
//		return view('ferma_training.plan.index',$data);
	}

	function fetchTrainingPlanApprovals(){
		return $this->fetchReusableTrainingPlan(true);
	}

	private function fetchReusableTrainingPlan($approval=false){
		$data = [];

		$data['cadres'] = Cadre::all();
		$data['workflows'] = Workflow::where('status',1)->get();
		$data['groups'] = UserGroup::where('company_id',companyId())->get();
		$data['list'] = (new TrTrainingPlan)->fetch()->paginate(20);

		$ref = $this;
		$data['approvalView'] = function($trainingPlanObject) use ($ref){
			return $ref->fetchApprovals($trainingPlanObject)->render();
		};

		$data['approvalInlineView'] = function($trainingPlanObject) use ($ref){
			return $ref->fetchInlineApproval($trainingPlanObject)->render();
		};

		$data['budget'] = $this->fetchBudget()->render();

		$data['setting'] = $this->fetchSettings()->render();

		$data['approval'] = $approval;
//		if (request()->filled('approval'))
//			$data['approval'] = true;
//		dd($data);

		return view('ferma_training.plan.index',$data);
	}

	function fetchUserTraining(){

		$data = [];

		$data['list'] = (new TrUserTraining)->fetch()->paginate(20);

		return view('ferma_training.user_training.index',$data);

	}


	function fetchApprovals($trainingPlanObject){

		$data = [];

		$data['action'] = true;
		$data['item'] = $trainingPlanObject;
		$data['trainingPlanObject'] = $trainingPlanObject;
		$data['list'] = $trainingPlanObject->training_plan_approvals()->orderBy('id','desc')->get(); // (new TrTrainingPlanApprovals)->fetch()->paginate(20);

		return view('ferma_training.approvals.index',$data);

	}

	private function fetchInlineApproval($trainingPlanObject){
		//ferma_training.approvals.table_partial
		$data = [];
		$data['action'] = false;

		$data['item'] = $trainingPlanObject;
		$data['trainingPlanObject'] = $trainingPlanObject;
		$data['list'] = $trainingPlanObject->training_plan_approvals()->orderBy('id','desc')->get(); // (new TrTrainingPlanApprovals)->fetch()->paginate(20);

		return view('ferma_training.approvals.table_partial',$data);

	}

	function getGroupUsers(){
		return (new TrTrainingPlan)->getGroupUsers();
	}

	function getCadreUsers(){
		return (new TrTrainingPlan)->getCadreUsers();
	}


	function fetchSettings(){
		$data = [];

		$data['list'] = (new TrTrainingSettings)->fetch()->get();

		return view('ferma_training.settings.index',$data);
	}




}
