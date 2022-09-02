<?php
/**
 * Created by PhpStorm.
 * User: NnamdiAlexanderAkamu
 * Date: 6/25/2020
 * Time: 12:35 AM
 */

namespace App\ClassMaps;


use App\TrManPowerTraining;
use App\TrManPowerTrainingApprovals;
use App\TrTrainingBudget;
use App\TrTrainingPlan;
use App\TrTrainingPlanApprovals;
use App\TrUserManPowerTraining;
use App\TrUserTraining;

class Kernel
{

	private $maps = [];


	function loadMaps(){


		$this->maps = [

			'tr_training_plan'=>TrTrainingPlan::class,
			'tr_man_power_training'=>TrManPowerTraining::class,
			'tr_man_power_training_approvals'=>TrManPowerTrainingApprovals::class,
			'tr_training_budget'=>TrTrainingBudget::class,
			'tr_training_plan_approvals'=>TrTrainingPlanApprovals::class,
			'tr_user_man_power_training'=>TrUserManPowerTraining::class,
			'tr_user_training'=>TrUserTraining::class
		];

	}


	function hasClassMap($name){
		return isset($this->maps[$name]);
	}

	function getClassMap($name){
		return $this->maps[$name];
	}



}