<?php

use Illuminate\Database\Seeder;

class VotePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission_category=\App\PermissionCategory::insertGetId(['name'=>'Voting']);
        $permision_data=[
            ['name'=>'Configure Vote','constant'=>'configure_vote','permission_category_id'=>$permission_category],
            ['name'=>'View Vote Result','constant'=>'view_result','permission_category_id'=>$permission_category]
        ];
        foreach($permision_data as $data){
            \App\Permission::create($data);
        }
//        $permission=\DB::insert("INSERT INTO 'permission_categories' ('id', 'name', 'created_at', 'updated_at') VALUES (NULL, 'Voting', '2020-06-30 13:23:46', '2020-06-30 13:23:46')");
    }
}
