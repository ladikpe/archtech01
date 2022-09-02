<?php

use Illuminate\Database\Seeder;
use Fzaninotto\Faker\Generator as Faker;

class UserCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    /*



    */
    public function run()
    {
    	$users=App\User::all();
        $companies=App\Company::all();
        $company_count=$companies->count();
        $cnt=0;
    	foreach ($users as $user) {

           $user->company_id=$companies[$cnt]->company_id;
           $user->save();
           $cnt++;
           if ($cnt==$company_count-1) {
               $cnt=0;
           }
        }
    	
    	}

    	
        // for ($i=1; $i <31 ; $i++) {


        // 	// $faker=Faker\Factory::create();
        // 	// $attendance= new App\Attendance;
        // 	// $attendance->emp_num=$i;
        // 	// $attendance->date=date('Y-m-d');
        // 	// $attendance->shift_id=1;
        // 	// $attendance->save();

        // }
    }

