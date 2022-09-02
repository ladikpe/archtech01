<?php

use Illuminate\Database\Seeder;


class AssignCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // $users=["PNG/002","PNG/009","PNG/010","PNG/012","PNG/025","PNG/026","PNG/027","PNG/028","PNG/029","PNG/030","PNG/031","PNG/034","PNG/037","PNG/039","PNG/043","PNG/044","PNG/047","PNG/048","PNG/049","PNG/050","PNG/051","PNG/052","PNG/053","PNG/054","PNG/057","PNG/085","PNG/099","PNG/104","PNG/106","PNG/109","PNG/112","PNG/115","PNG/117","PNG/122","PNG/125","PNG/128","PNG/129","PNG/130","PNG/131","PNG/132","PNG/135","PNG/136","PNG/137","PNG/138","PNG/140","PNG/142","PNG/143","PNG/145","PNG/146","PNG/148","PNG/149","PNG/150","PNG/152","PNG/153","PNG/154","PNG/162","PNG/166","PNG/167","PNG/170","PNG/171","PNG/172","PNG/176","PNG/178","PNG/186","PNG/187","PNG/189","PNG/191","PNG/192","PNG/198","PNG/199","PNG/202","PNG/203","PNG/218","PNG/221","PNG/234","PNG/241","PNG/249","PNG/250","PNG/251","PNG/252","PNG/256","PNG/264","PNG/265","PNG/266","PNG/270","PNG/272","PNG/276","PNG/277","PNG/280","PNG/281","PNG/284","PNG/286","PNG/287","PNG/290","PNG/296","PNG/297","PNG/302","PNG/309","PNG/314","PNG/315","PNG/316","PNG/317","PNG/318","PNG/319","PNG/320","PNG/321","PNG/322","PNG/323","PNG/324","PNG/325","PNG/326","PNG/327","PNG/328","PNG/329","PNG/330","PNG/331","PNG/332","PNG/333","PNG/334","PNG/335","PNG/337","PNG/338","PNG/339","PNG/340","PNG/341","PNG/342","PNG/343","PNG/344","PNG/345","PNG/346","PNG/347","PNG/350","PNG/351","PNG/352","PNG/353","PNG/355","PNG/356","PNG/358","PNG/359","PNG/360","PNG/361","PNG/362","PNG/364","PNG/365","PNG/366","PNG/367","PNG/368","PNG/369","PNG/370","PNG/371","PNG/372","PNG/373","PNG/374","PNG/375","PNG/376","PNG/377","PNG/378","PNG/379","PNG/380","PNG/381","PNG/382","PNG/383","PNG/384","PNG/385","PNG/386","PNG/387","PNG/388","PNG/389","PNG/390","PNG/391","PNG/392","PNG/393","PNG/394","PNG/395","PNG/396","PNG/397","PNG/398","PNG/399","PNG/400","PNG/401","PNG/402","PNG/403","PNG/404","PNG/405","PNG/406","PNG/407","PNG/408","PNG/409","PNG/410","PNG/411","PNG/412","PNG/413","PNG/414","PNG/415","PNG/416","PNG/417","PNG/418","PNG/419","PNG/420","PNG/421","PNG/422","PNG/423","PNG/424","PNG/425","PNG/426","PNG/427","PNG/428","PNG/429","PNG/430","PNG/431","PNG/432","PNG/433","PNG/434","PNG/435","PNG/436","PNG/437","PNG/438","PNG/439","PNG/440","PNG/441","PNG/442","PNG/443","PNG/444","PNG/445","PNG/446","PNG/447","PNG/448","PNG/449","PNG/450","PNG/451","PNG/452","PNG/453","PNG/454","PNG/455","PNG/456","PNG/457","PNG/458","PNG/459","PNG/460","PNG/461","PNG/462","PNG/463","PNG/464","PNG/465","PNG/466","PNG/467","PNG/468","PNG/469","PNG/470","PNG/471","PNG/472","PNG/473"];
       // $i=1;
       // foreach ($users as $user) {
       //  $faker = Faker\Factory::create();
       //  $gender = $faker->randomElements(['male', 'female']);
       //   $new_user=App\User::create([
       //              'emp_num'=>$user,
       //              'name'=>$faker->name($gender),
       //              'address'=>$faker->streetAddress,
       //              'company_id'=>8,
       //              'email'=>$faker->safeEmail,
       //              // 'sex'=>$gender,
       //              'dob'=>$faker->date($format = 'Y-m-d', $max = '-21 years'),
       //              'hiredate'=>$faker->date($format = 'Y-m-d', $max = 'now'),
       //              'role_id'=>4,
       //              'status'=>1]);

       //   $hist=App\PromotionHistory::where('user_id',$new_user->id)->first();
       //      if(!$hist){
               
       //          $hist=App\PromotionHistory::create(['user_id'=>$new_user->id,'approved_by'=>1,'approved_on'=>date('Y-m-d'),'old_grade_id'=>$i,'grade_id'=>$i]);
       //      }
       //      $i++;
       //      if ($i==4) {
       //          $i=1;
       //      }
       // }
      //create jobs
      // $departments=App\Department::all();
      // foreach ($departments as $department) {
      //   for ($i=0; $i <=7 ; $i++) { 
      //   $faker = Faker\Factory::create();
      //   $jobname=$faker->jobTitle;
      //   $job= App\Job::create([
      //     'title'=>$jobname,
      //     'description'=>$jobname,
      //     'department_id'=>$department->id,
      //     'personnel'=>mt_rand(1,4)
      //   ]);
      // }
      // }
  //     $users=App\User::where('company_id',8)->get();
  // $i=1;
  //     foreach ($users as $user) {

  //      $user->update(['job_id'=>$i]);
  //      $i++;
  //      if ($i>=34) {
  //       $i=1;
  //      }
  //     }
      // $jobs=App\Job::all();
      // foreach ($jobs as $job) {
      //  $job->update(['personnel'=>rand(1,5)]);
      // }

      // $users=App\User::all();
      // foreach($users as $user){
      //   $faker = Faker\Factory::create();
      //   $gender = ['male', 'female'];
      //    $key = array_rand($gender);
      //   $sex= $gender[$key];
      //   $male = array('father','son','nephew','uncle','brother');
      //   $female = array('mother','daughter','niece','aunt','sister');
      //   $rel='';
      //   if ( $sex=='male') {
      //  $key = array_rand($male);
      //   $rel= $male[$key];
      //   }elseif ($sex=='female') {
      //    $key = array_rand($female);
      //   $rel= $female[$key];
      //   }
        
        
      //   $nok= App\Nok::create([
      //     'name'=>$faker->name($sex),
      //     'address'=>$faker->address,
      //     'user_id'=>$user->id,
      //     'phone'=>$faker->e164PhoneNumber,
      //     'relationship'=>$rel
      //   ]);

      // }

      // $users=App\User::all();
      // foreach($users as $user){
      //   $faker = Faker\Factory::create();
      //   $user->update(
      //     ['dob'=>$faker->dateTimeBetween($startDate = '-50 years', $endDate = '-22 years', $timezone = null),
      //     'hiredate'=>$faker->dateTimeThisDecade($max = 'now', $timezone = null),
      //     'created_at'=>$faker->dateTimeThisYear($max = 'now', $timezone = null)
      //   ]);
      // }

      $users=App\User::has('promotionHistories.grade')->get();
       // $cnt=1000;
      foreach($users as $user){
        // $faker = Faker\Factory::create();
       // $num=$cnt+1;
        // $companies=App\Company::all();
        $user_grade=$user->promotionHistories()->latest()->first()->grade;
        // $user_job=$user->jobs()->latest()->first();
        $user->grade_id=$user_grade->id;
        $user->save();

        // echo $user->company->has('departments')->jobs()->inRandomOrder()->first()->id.'-';
        // $user->jobs()->attach($user->company->jobs()->inRandomOrder()->first()->id,['started'=>$user->hiredate]);
        
      }

      //  $users=App\User::all();
      //  // $cnt=1000;
      // foreach($users as $user){
      //   // $faker = Faker\Factory::create();
      //  // $num=$cnt+1;
      //   $company=App\Company::inRandomOrder()->first();
      //   $user->update(['company_id'=>$company['id']]);
        
        
      // }

//       $companies=App\Company::where('id','!=',8)->get();
//       foreach ($companies as $company) {
//         $company->departments()->createMany([
//     [
//         'name' => 'Admin','manager_id'=>$company->users()->inRandomOrder()->first()['id']
//     ],
//     [
//         'name' => 'Drivers','manager_id'=>$company->users()->inRandomOrder()->first()['id']
//     ],
//     [
//         'name' => 'Section 1','manager_id'=>$company->users()->inRandomOrder()->first()['id']
//     ],
//     [
//         'name' => 'Section 2','manager_id'=>$company->users()->inRandomOrder()->first()['id']
//     ],
// ]);
        
//       }

    	
    }
}
