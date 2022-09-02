<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToUserTemps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Schema::table('user_temps', function (Blueprint $table) {
            $table->integer('rank_id')->default(0);
            $table->integer('cadre_id')->default(0);
            $table->integer('pension_fund_administrator_id')->default(0);
            $table->string('pension_account_no')->nullable();
            $table->integer('field_office_id')->default(0);
            $table->integer('workstate_id')->default(0);
            $table->integer('unit_id')->default(0);
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       /* Schema::table('user_temps', function (Blueprint $table) {
            $table->dropColumn('rank_id');
            $table->dropColumn('pension_fund_administrator_id');
            $table->dropColumn('pension_account_no');
            $table->dropColumn('cadre_id');
            $table->dropColumn('field_office_id');
            $table->dropColumn('workstate_id');
            $table->dropColumn('unit_id');
        });*/
    }
}
