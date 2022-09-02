<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TrTrainingBudgetMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
	    Schema::create('tr_training_budget_ferma', function(Blueprint $blueprint){

	    	$blueprint->increments('id');

	    	$blueprint->integer('year')->nullable();
	    	$blueprint->integer('cadre_id')->nullable();
	    	$blueprint->integer('total_amount')->nullable();
	    	$blueprint->string('created_by')->nullable();

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
	    Schema::dropIfExists('tr_training_budget_ferma');
    }

}
