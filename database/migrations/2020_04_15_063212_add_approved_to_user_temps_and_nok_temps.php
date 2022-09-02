<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApprovedToUserTempsAndNokTemps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

      /*  Schema::table('user_temps', function (Blueprint $table) {
            $table->timestamp('last_change_approved_on')->nullable();
        });
        Schema::table('user_temps', function (Blueprint $table) {
            $table->integer('last_change_approved')->default(1);
        });
        Schema::table('user_temps', function (Blueprint $table) {
            $table->integer('last_change_approved_by')->default(0);
        });
        Schema::table('nok_temps', function (Blueprint $table) {
            $table->timestamp('last_change_approved_on')->nullable();
        });
        Schema::table('nok_temps', function (Blueprint $table) {
            $table->integer('last_change_approved')->default(1);
        });
        Schema::table('nok_temps', function (Blueprint $table) {
            $table->integer('last_change_approved_by')->default(0);
        });
        Schema::table('user_temps', function (Blueprint $table) {
            $table->date('last_promoted')->nullable();
        });*/

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*Schema::table('user_temps', function (Blueprint $table) {
            $table->dropColumn('last_change_approved');
        });
        Schema::table('user_temps', function (Blueprint $table) {
            $table->dropColumn('last_change_approved_on');
        });
        Schema::table('user_temps', function (Blueprint $table) {
            $table->dropColumn('last_change_approved_by');
        });
        Schema::table('nok_temps', function (Blueprint $table) {
            $table->dropColumn('last_change_approved');
        });
        Schema::table('nok_temps', function (Blueprint $table) {
            $table->dropColumn('last_change_approved_on');
        });
        Schema::table('nok_temps', function (Blueprint $table) {
            $table->dropColumn('last_change_approved_by');
        });
        Schema::table('user_temps', function (Blueprint $table) {
            $table->dropColumn('last_promoted');
        });*/

    }
}
