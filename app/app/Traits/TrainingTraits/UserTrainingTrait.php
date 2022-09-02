<?php
/**
 * Created by PhpStorm.
 * User: NnamdiAlexanderAkamu
 * Date: 6/27/2020
 * Time: 10:33 PM
 */

namespace App\Traits\TrainingTraits;


use App\TrUserTraining;

trait UserTrainingTrait
{

	function updateFeedback(){

		$id = request('id');
		$obj = TrUserTraining::find($id);

        $obj->feedback = request('feedback');
        $obj->rating = request('rating');
        $obj->completed = request()->filled('completed')? 1 : 0;

		$obj->save();

		return [
			'message'=>'Feedback saved',
			'error'=>false
		];

	}


}