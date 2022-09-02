<?php

use App\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VisitorPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pc=\App\PermissionCategory::updateorcreate(['name'=>'Visitor Module']);

        $permission_1=Permission::updateorcreate(['permission_category_id'=>$pc->id,'name'=>'Admin Dashboard','constant'=>'admin_dashboard']);
        $permission_2=Permission::updateorcreate(['permission_category_id'=>$pc->id,'name'=>'Book Visit','constant'=>'book_visit']);
        $permission_3=Permission::updateorcreate(['permission_category_id'=>$pc->id,'name'=>'Front Desk','constant'=>'front_desk']);

        DB::table('permission_role')->insert(['permission_id'=>$permission_1->id,'role_id'=>'1']);
        DB::table('permission_role')->insert(['permission_id'=>$permission_2->id,'role_id'=>'1']);
        DB::table('permission_role')->insert(['permission_id'=>$permission_3->id,'role_id'=>'1']);


    }
}
