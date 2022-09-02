<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrTrainingSettings extends Model
{
    //
	protected $table = 'tr_training_settings';


	function getSetting($key){
	   $query = (new TrTrainingSettings)->newQuery();
	   if ($this->hasSetting($key)){
	   	$query = $query->where('name',$key);
	   	return $query->first()->content;
	   }

	   return null;
	}

	function saveSetting(){

		$key = request('key');
		$content = request('content');

		if ($this->hasSetting($key)){
		  $obj = (new TrTrainingSettings)->newQuery()->where('name',$key)->first();
		  $obj->content = $content;
		  $obj->save();

		  return [
		  	'message'=>'Settings saved',
			'error'=>false,
			'modal'=>'#setting-container'
		  ];
		}

		$obj = new TrTrainingSettings;
		$obj->name = $key;
		$obj->content = $content;
		$obj->save();

		return [
			'message'=>'New Settings Added',
			'error'=>false,
			'modal'=>'#setting-container'
		];

	}

	function removeSetting(){
		$key = request('key');
		if ($this->hasSetting($key)){
			$obj = (new TrTrainingSettings)->newQuery()->where('name',$key)->first();
			$obj->delete();
			return [
				'message'=>'Setting removed',
				'error'=>false,
				'modal'=>'#setting-container'
			];
		}

		return [
			'message'=>'Setting not found',
			'error'=>true,
			'modal'=>'#setting-container'
		];

	}

	function hasSetting($key){
		$query = (new TrTrainingSettings)->newQuery();
		$query = $query->where('name',$key);
		return $query->exists();
	}

	function fetch(){
		$query = (new TrTrainingSettings)->newQuery();



		return $query;
	}



}
