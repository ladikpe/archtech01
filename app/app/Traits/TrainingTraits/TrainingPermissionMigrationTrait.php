<?php
/**
 * Created by PhpStorm.
 * User: NnamdiAlexanderAkamu
 * Date: 7/6/2020
 * Time: 11:39 PM
 */

namespace App\Traits\TrainingTraits;


use App\Permission;
use App\PermissionCategory;

trait TrainingPermissionMigrationTrait
{


	function handlePermissionMigration(){
		$nameCheck = 'Offline Training';
		$permissionCategoryId = null;
		if (PermissionCategory::where('name',$nameCheck)->count() <= 0){

			$obj = new PermissionCategory;
			$obj->name = $nameCheck;
			$obj->save();
			$permissionCategoryId = $obj->id;

		}else{
			$obj = PermissionCategory::where('name',$nameCheck)->first();
			$permissionCategoryId = $obj->id;
		}

		$permissions = [
			[
				'name'=>'Manage Training Budget',
				'constant'=>'manage_training_budget',
				'description'=>'Allocate Training Budget',
				'permission_category_id'=>$permissionCategoryId
			],
			[
				'name'=>'Manage Training Plan',
				'constant'=>'manage_training_plan',
				'description'=>'Manage Training Plan',
				'permission_category_id'=>$permissionCategoryId
			],

			[
				'name'=>'Approve Training Plan',
				'constant'=>'approve_training_plan_offline',
				'description'=>'Approve Training Plan',
				'permission_category_id'=>$permissionCategoryId
			],

			[
				'name'=>'Access Training',
				'constant'=>'access_training',
				'description'=>'Access Training',
				'permission_category_id'=>$permissionCategoryId
			]
//			[
//				'name'=>'Upload Training Plan',
//				'constant'=>'upload_training_plan',
//				'description'=>'Upload Course Plan',
//				'permission_category_id'=>$permissionCategoryId
//			],
//			[
//				'name'=>'Approve Training Plan',
//				'constant'=>'approve_training_plan',
//				'description'=>'Approve Training Plan',
//				'permission_category_id'=>$permissionCategoryId
//			],
//			[
//				'name'=>'Upload Training Budget',
//				'constant'=>'upload_training_budget',
//				'description'=>'Upload Training Budget',
//				'permission_category_id'=>$permissionCategoryId
//			]


		];


		foreach ($permissions as $permission){

			$checkPermConstant = $permission['constant'];
			if (Permission::where('constant',$checkPermConstant)->count() <= 0){
				$obj = new Permission;
				$obj->name = $permission['name'];
				$obj->constant = $permission['constant'];
				$obj->description = $permission['description'];
				$obj->permission_category_id = $permissionCategoryId;
				$obj->save();
			}

		}
	}


}