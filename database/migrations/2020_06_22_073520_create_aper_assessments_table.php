<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAperAssessmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //'aper_measurement_period_id','employee_id','manager_id','manager_approved','employee_approved','manager_approved_date',
        //'employee_approved_date','created_by','updated_by','company_id','manager_comment','employee_comment','score'
        Schema::create('aper_assessments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('aper_measurement_period_id');
            $table->integer('employee_id')->default(0);
            $table->integer('manager_id')->default(0);
            $table->integer('manager_approved')->default(0);
            $table->integer('employee_approved')->default(0);
            $table->integer('manager_approved_date')->nullable();
            $table->integer('employee_approved_date')->nullable();
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->integer('company_id')->default(0);
            $table->integer('manager_comment')->nullable();
            $table->integer('employee_comment')->nullable();
            $table->integer('score')->nullable();
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
        Schema::dropIfExists('aper_assessments');
    }
}
