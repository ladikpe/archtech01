<?php

use App\Poll;
use App\PollQuestion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pc=\App\PermissionCategory::updateorcreate(['name'=>'Polls']);
        $permission_1=\App\Permission::create(['permission_category_id'=>$pc->id,'constant'=>'create_poll','name'=>'Create Poll']);
        $permission_2=\App\Permission::create(['permission_category_id'=>$pc->id,'constant'=>'take_poll','name'=>'Participate in Poll']);

        DB::table('permission_role')->insert(['permission_id'=>$permission_1->id,'role_id'=>'1']);
        DB::table('permission_role')->insert(['permission_id'=>$permission_2->id,'role_id'=>'1']);

        /*for ($i=0; $i<8; $i++){
            $poll=Poll::create(['name'=>"Who should win the award $i ?",'user_id'=>'1','description'=>'Details on who should be the winner','end_date'=>'2020-05-20','status'=>'active','type'=>'normal','roles'=>[],'groups'=>[],'departments'=>[]]);
            $options=[['id'=>'1','option'=>'Mr A'],['id'=>'2','option'=>'Mr B'],['id'=>'3','option'=>'Mr C'],['id'=>'4','option'=>'Mr D']];
            for ($a=0; $a<5; $a++){
                PollQuestion::updateorcreate(['poll_id'=>$poll->id,'question'=>'Early comer','options'=>$options]);
            }
        }*/
    }
}
