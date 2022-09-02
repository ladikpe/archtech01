<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TrainingPlanAlterMigration extends Migration
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

	    	$blueprint->integer('status')->nullable();
	    	$blueprint->string('type')->comments('empowerment or cadre')->nullable();
	    	$blueprint->longText('empower_user_id')->nullable();

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

		    $blueprint->dropColumn('status');
		    $blueprint->dropColumn('type');
		    $blueprint->dropColumn('empower_user_id');

	    });

    }
}
