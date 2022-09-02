<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToAttendanceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attendance_details', function (Blueprint $table) {
            $table->string('clock_in_lat')->nullable();
            $table->string('clock_in_long')->nullable();
            $table->string('clock_out_lat')->nullable();
            $table->string('clock_out_long')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attendance_details', function (Blueprint $table) {
            $table->dropColumn('clock_in_lat');
            $table->dropColumn('clock_in_long');
            $table->dropColumn('clock_out_lat');
            $table->dropColumn('clock_out_long');
        });
    }
}
