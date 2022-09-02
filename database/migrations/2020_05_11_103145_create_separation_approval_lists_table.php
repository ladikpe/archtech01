<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeparationApprovalListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('separation_approval_lists', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->integer('created_by');
            $table->integer('company_id');

//            $table->integer('company_id');
            $table->integer('save_profile');
            $table->integer('save_');
//            $table->integer('company_id');

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
        Schema::dropIfExists('separation_approval_lists');
    }
}
