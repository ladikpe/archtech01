<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TrainingPlanAlter3Migration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
	    Schema::table('tr_training_plan', function(Blueprint $blueprint){


	    	$blueprint->integer('group_id')->nullable();
	    	$blueprint->string('group_type')->nullable();

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
	    Schema::table('tr_training_plan', function(Blueprint $blueprint){


		    $blueprint->dropColumn('group_id');
		    $blueprint->dropColumn('group_type');

	    });

    }
}
