<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserTrainingAlterMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
	    Schema::table('tr_user_training', function (Blueprint $blueprint){
	    	$blueprint->integer('completed')->nullable();
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
	    Schema::table('tr_user_training', function (Blueprint $blueprint){
		    $blueprint->dropColumn('completed');
	    });
    }
}
