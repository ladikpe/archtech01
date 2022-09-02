<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TrManPowerTrainingMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
	    Schema::create('tr_man_power_training', function(Blueprint $blueprint){

	    	$blueprint->increments('id');

	    	$blueprint->integer('user_id')->nullable();
//	    	$blueprint->integer('carder_id')->nullable();
	    	$blueprint->integer('workflow_id')->nullable();
	    	$blueprint->string('course_name')->nullable();
	    	$blueprint->string('cost')->nullable();

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
	    Schema::dropIfExists('tr_man_power_training');
    }
}
