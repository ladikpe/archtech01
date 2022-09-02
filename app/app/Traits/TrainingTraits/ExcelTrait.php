<?php
/**
 * Created by PhpStorm.
 * User: NnamdiAlexanderAkamu
 * Date: 6/29/2020
 * Time: 9:44 AM
 */

namespace App\Traits\TrainingTraits;


use Excel;

trait ExcelTrait
{


	function hasExcelFile($inputName){
		return request()->file($inputName);
	}

	function importExcel($inputName,callable $callback){

		if (request()->file($inputName)){

			$path = request()->file($inputName)->getRealPath();
			$data = Excel::load($path)->get();
//			$ref = $this;

//			dd($data->toArray());

			if ($data->count() > 0){

				foreach ($data->toArray() as $k=>$v){

					$callback($v);

//					$newRecord = (new Tr_TrainingBudget)->entityCreate(function($record) use ($ref,$v){
//
//						$record->hr_id = Auth::user()->id;
//						$record->grade_id = $ref->getGradeIdFromLevel($v['grade']);
//						$record->training_budget_name = $v['name'];
//						$record->allocation_total = $v['allocation_total'];
//						$record->year_of_allocation = date('Y');
//
//						return $record;
//					});


				}

			}
//			dd('bulk detected');

		}

	}

}