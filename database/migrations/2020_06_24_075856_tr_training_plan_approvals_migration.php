<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TrTrainingPlanApprovalsMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
	    Schema::create('tr_training_plan_approvals', function(Blueprint $blueprint){

	    	$blueprint->increments('id');

	    	$blueprint->integer('tr_training_plan_id')->nullable();
	    	$blueprint->integer('stage_id')->nullable();
	    	$blueprint->integer('approver_id')->nullable();
	    	$blueprint->text('comments')->nullable();
	    	$blueprint->integer('status')->nullable();
	    	$blueprint->longText('signature')->nullable();
	    	$blueprint->integer('company_id')->nullable();

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
	    Schema::dropIfExists('tr_training_plan_approvals');
    }
}
