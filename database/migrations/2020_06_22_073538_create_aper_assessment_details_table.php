<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAperAssessmentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //'user_id','aper_assessment_id','aper_sub_metric_id','created_by','updated_by','score'
        Schema::create('aper_assessment_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('aper_assessment_id');
            $table->integer('aper_sub_metric_id');
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->decimal('score',8,2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aper_assessment_details');
    }
}
