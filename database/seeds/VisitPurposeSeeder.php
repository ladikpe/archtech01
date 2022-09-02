<?php

use Illuminate\Database\Seeder;

class VisitPurposeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $purposes=['official','personal','executive'];
        foreach ($purposes as $purpose){
            $new=new \App\VisitPurpose();
            $new->name=$purpose;
            $new->save();
        }
    }
}
