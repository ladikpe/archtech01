<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManualAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('manual_attendances');
        Schema::create('manual_attendances', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->string('company_id');
            $table->string('created_by');
            $table->date('date');
            $table->dateTime('time_in');
            $table->dateTime('time_out');
            $table->string('reason');
            $table->string('status');
            $table->string('workflow_id')->default('1');
            $table->string('workflow_details')->nullable();
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
        Schema::dropIfExists('manual_attendances');
    }
}
