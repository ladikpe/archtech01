<?php

use App\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerformancePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pc=\App\PermissionCategory::where('name','Performance')->first();
        $permission_1=Permission::updateorcreate(['permission_category_id'=>$pc->id,'name'=>'Upload Promotion List','constant'=>'upload_promotion_list']);
        $permission_2=Permission::updateorcreate(['permission_category_id'=>$pc->id,'name'=>'Upload Exam Score','constant'=>'upload_exam_score']);

        DB::table('permission_role')->insert(['permission_id'=>$permission_1->id,'role_id'=>'1']);
        DB::table('permission_role')->insert(['permission_id'=>$permission_2->id,'role_id'=>'2']);
    }
}
