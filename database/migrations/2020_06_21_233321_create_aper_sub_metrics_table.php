<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAperSubMetricsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('aper_sub_metrics', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('aper_metric_id');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('editable')->default(0);
            $table->integer('user_id')->default(0);
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
        Schema::dropIfExists('aper_sub_metrics');
    }
}
