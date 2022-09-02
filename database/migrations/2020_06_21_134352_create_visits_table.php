<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->string('visitor_id');
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->date('date');
            $table->time('time');
            $table->string('gender');
            $table->string('purpose_id');
            $table->string('initiated_by')->default('visitor');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->enum('status',['pending','approved','declined','cancelled','started','progress','ended'])->nullable();
            $table->string('signature')->nullable();
            $table->string('passport')->nullable();
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
        Schema::dropIfExists('visits');
    }
}
