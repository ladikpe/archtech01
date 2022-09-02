<?php

use App\Poll;
use App\PollQuestion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

//        $this->seedQuery();
//        $this->seedNotificationTypes();
//        $this->seedNotificationMessages();

//
//        $this->seedQuery();
//        $this->seedNotificationTypes();
//
//        $this->seedNotificationMessages();
//        $this->queryPermissionSeeder();

$this->seedPoll();
    }

    public function seedNotificationTypes()
    {
        $this->cleantable('notification_types');
        $notification_types = ['Birthday', 'Anniversary', 'Public Holidays', 'Query'];
        foreach ($notification_types as $not_type) {
            \DB::table('notification_types')->insert(['name' => $not_type]);
        }
    }

    public function cleantable($tbl_name)
    {
        \DB::table($tbl_name)->truncate();
    }

    public function seedNotificationMessages()
    {
//        \DB::table('notification_messages')->truncate();
        $this->cleantable('notification_messages');
        $messages = [['message' => 'Dear %name% , today %dob% test %hiredate% ', 'notification_type_id' => 1, 'a_id' => 1, 'company_id' => 1], ['message' => 'Dear %name% , today %dob% test %hiredate%', 'notification_type_id' => 2, 'a_id' => 1, 'company_id' => 1]];
        foreach ($messages as $message) {
            \DB::table('notification_messages')->insert($message);
        }
    }


    public function queryPermissionSeeder()
    {
//        $this->cleantable('permissions');
        \App\Permission::where('permission_category_id', 22)->delete();
//        \App\PermissionCategory::whereIn('id', [22,23])->delete();
        \App\PermissionCategory::updateOrCreate(['name'=>'Probation']);
        $permissions = [
            ['name' => 'Issue Query', 'constant' => 'issue_query', 'permission_category_id' => 22],
            ['name' => 'Query Escalation Settings', 'constant' => 'query_escalation_settings', 'permission_category_id' => 22],
            ['name' => 'Manage Probation Policy', 'constant' => 'manage_probation_policy', 'permission_category_id' => 23]
        ];
        foreach ($permissions as $permission) {
            \App\Permission::create($permission);
        }
    }

    public function seedQuery()
    {
        \App\QueryThread::where('id', '<>', 0)->delete();
        \App\Query::create(['title' => 'test Query', 'content' => 'Dear %name% sjsjsjs', 'created_by' => 1, 'company_id' => 8]);
        \App\Query::create(['title' => 'test Query', 'content' => 'Dear %name% sjsjsjs', 'created_by' => 1, 'company_id' => 9]);
        \App\Query::create(['title' => 'test Query', 'content' => 'Dear %name% sjsjsjs', 'created_by' => 1, 'company_id' => 10]);
        $datas = [
            ['queried_user_id' => 1, 'query_type_id' => 1, 'content' => 'Dear %name% sjsjsjs', 'created_by' => 1],
            ['queried_user_id' => 1, 'query_type_id' => 1, 'content' => 'Dear %name% sjsjsjs', 'created_by' => 1, 'parent_id' => 1],
            ['queried_user_id' => 1, 'query_type_id' => 1, 'content' => 'Dear %name% sjsjsjs', 'created_by' => 1],
            ['queried_user_id' => 1, 'query_type_id' => 1, 'content' => 'Dear %name% sjsjsjs', 'created_by' => 1, 'parent_id' => 2],
        ];
        foreach ($datas as $data) {

            \App\QueryThread::create($data);
        }
    }


    public function seedPoll(){
        $pc=\App\PermissionCategory::updateorcreate(['name'=>'Polls']);
        $permission_1=\App\Permission::create(['permission_category_id'=>$pc->id,'constant'=>'create_poll','name'=>'Create Poll']);
        $permission_2=\App\Permission::create(['permission_category_id'=>$pc->id,'constant'=>'take_poll','name'=>'Participate in Poll']);

        DB::table('permission_role')->insert(['permission_id'=>$permission_1->id,'role_id'=>'1']);
        DB::table('permission_role')->insert(['permission_id'=>$permission_2->id,'role_id'=>'1']);

        for ($i=0; $i<8; $i++){
            $poll=Poll::create(['name'=>"Who should win the award $i ?",'user_id'=>'1','description'=>'Details on who should be the winner','end_date'=>'2020-05-20','status'=>'active','type'=>'normal','roles'=>[],'groups'=>[],'departments'=>[]]);
            $options=[['id'=>'1','option'=>'Mr A'],['id'=>'2','option'=>'Mr B'],['id'=>'3','option'=>'Mr C'],['id'=>'4','option'=>'Mr D']];
            for ($a=0; $a<5; $a++){
                PollQuestion::updateorcreate(['poll_id'=>$poll->id,'question'=>'Early comer','options'=>$options]);
            }
        }
    }

}
