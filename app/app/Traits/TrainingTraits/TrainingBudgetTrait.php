<?php
/**
 * Created by PhpStorm.
 * User: NnamdiAlexanderAkamu
 * Date: 6/25/2020
 * Time: 9:55 AM
 */

namespace App\Traits\TrainingTraits;


use App\Cadre;
use App\TrTrainingBudget;
use Auth;

trait TrainingBudgetTrait
{

	use ExcelTrait;

	function createTrainingBudget(){

		if ($this->hasExcelFile('excel')){
			$this->importExcel('excel', function($data){

//				dd($data);

				$cadreObj = Cadre::where('name',$data['cadre'])->first();

				if (is_null($cadreObj)){
					return;
				}

				$obj = new TrTrainingBudget;
				$obj->year = date('Y');
				$obj->cadre_id = $cadreObj->id;
				$obj->total_amount = $data['total_amount']; // request()->get('total_amount');
				$obj->created_by = Auth::user()->id;
				$obj->save();


			});

			return [
				'message'=>'Excel imported successfully',
				'modal'=>'#budget',
				'error'=>false
			];
		}



		$obj = new TrTrainingBudget;
        $obj->year = date('Y');
        $obj->cadre_id = request('cadre_id');
        $obj->total_amount = request()->get('total_amount');
        $obj->created_by = Auth::user()->id;
		$obj->save();

		return [
			'message'=>'New Training Budget Added',
			'modal'=>'#budget',
			'error'=>false
		];
	}

	function updateTrainingBudget(){
		$obj = TrTrainingBudget::find(request('id'));
//		$obj->year = date('Y');
		$obj->cadre_id = request('cadre_id');
		$obj->total_amount = request()->get('total_amount');
		$obj->created_by = Auth::user()->id;
		$obj->save();

		return [
			'message'=>'Training Budget Updated',
			'modal'=>'#budget',
			'error'=>false
		];
	}

	function removeTrainingBudget(){
		$obj = TrTrainingBudget::find(request('id'));
		$obj->delete();

		return [
			'message'=>'Training Budget Removed',
			'modal'=>'#budget',
			'error'=>false
		];

	}

}