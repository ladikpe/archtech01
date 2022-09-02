<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TrUserTrainingMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
	    Schema::create('tr_user_training', function(Blueprint $blueprint){

	    	$blueprint->increments('id');

	    	$blueprint->integer('user_id')->nullable();
	    	$blueprint->integer('tr_training_plan_id')->nullable();
	    	$blueprint->text('feedback')->nullable();
	    	$blueprint->integer('rating')->nullable();

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
	    Schema::dropIfExists('tr_user_training');
    }

}
