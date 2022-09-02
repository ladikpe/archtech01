<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TrTrainingPlanMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
	    Schema::create('tr_training_plan', function(Blueprint $blueprint){
	    	
	    	$blueprint->increments('id');
	    	
	        $blueprint->integer('year_of_training')->nullable();
	        $blueprint->string('name_of_training')->nullable();
	        $blueprint->integer('number_of_participants')->nullable();
	        $blueprint->integer('workflow_id')->nullable();
	        $blueprint->integer('cadre_id')->nullable();
	        $blueprint->string('cost_per_head')->nullable();
	        $blueprint->integer('total_cost')->nullable();
	        $blueprint->integer('created_by')->nullable();
	    	
	    	$blueprint->timestamps();
	    	
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
	    Schema::dropIfExists('tr_training_plan');
    }
    
}
