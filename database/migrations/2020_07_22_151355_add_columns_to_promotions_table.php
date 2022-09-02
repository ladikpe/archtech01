<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToPromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('promotions');
        Schema::create('promotions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->string('emp_num');
            $table->string('state')->nullable();
            $table->string('dob')->nullable();
            $table->string('first_appointment')->nullable();
            $table->string('date_of_confirmation')->nullable();
            $table->string('present_appointment')->nullable();
            $table->string('old_rank')->nullable();
            $table->string('new_rank')->nullable();
            $table->string('year');
            $table->string('exam_number')->nullable();
            $table->string('exam_score')->nullable();
            $table->string('exam_score_uploaded_by')->nullable();
            $table->string('aper_score')->nullable();
            $table->string('seniority_score')->nullable();
            $table->string('tries')->default(1)->nullable();
            $table->string('status')->nullable();
            $table->string('type')->nullable();
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
        //
    }
}
