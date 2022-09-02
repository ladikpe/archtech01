<?php

use App\Cadre;
use App\Grade;
use App\Rank;
use Illuminate\Database\Seeder;

class RankAndCadreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $grades=['9','10','12','13','14','15','16','17'];
        $ranks=['Civil Engineer I','Senior Civil Engineer',  'Principal Civil Engineer','Assistant Chief Civil Engineer','Chief Civil Engineer', 'Assistant Director (Civil)','Deputy Director (Civil)','Director (Civil)'];
        $cadres=['Civil Engineering Cadre'];
        foreach ($grades as $grade){
            $grade_check=Grade::where(['level'=>$grade])->first();
            if (!$grade_check){
                $new_grade=Grade::create(['level'=>$grade]);
            }
        }
        foreach ($cadres as $cadre){
            $new_cadre=Cadre::where(['name'=>$cadre])->first();
            if(!$new_cadre){
                $cadre=Cadre::create(['name'=>$cadre]);
                $rank_count=count($ranks);
                for($i=0;$i<$rank_count;$i++){
                    $rank=Rank::create(['cadre_id'=>$cadre->id,'name'=>$ranks[$i],'grade_id'=>$grades[$i],'position'=>$i+1]);
                }
            }

        }

    }
}
