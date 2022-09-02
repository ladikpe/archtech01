<?php
/**
 * Created by PhpStorm.
 * User: NnamdiAlexanderAkamu
 * Date: 6/28/2020
 * Time: 9:51 PM
 */

namespace App\Traits\TrainingTraits;


use App\User;

trait UserFilterTrait
{

	function ajaxSearchUser($searchText){
		$query = (new User)->newQuery();
		$query = $query->where('name','like','%' . $searchText . '%');
		$query = $query->orWhere('email','like','%' . $searchText . '%');
		$collection = $query->get()->toArray();
		$collection = array_map(function ($item){
			return [
				'text'=>$item['name'],
				'id'=>$item['id']
			];
		}, $collection);
		return [
			'results'=>$collection
		];
	}

}