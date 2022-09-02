<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TrManPowerTrainingApprovalsMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
	    Schema::create('tr_man_power_training_approvals', function (Blueprint $blueprint){

	    	$blueprint->increments('id');

	    	$blueprint->integer('tr_man_power_training_id')->nullable();

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
	    Schema::dropIfExists('tr_man_power_training_approvals');
    }

}
