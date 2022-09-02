<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUploadToDocumentRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('document_request_types', function(Blueprint $blueprint){
            $blueprint->integer('has_upload')->default(0);
        });
        Schema::table('document_requests', function(Blueprint $blueprint){
            $blueprint->text('employee_file')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('document_requests', function(Blueprint $blueprint){
            $blueprint->dropColumn('employee_file');
        });
        Schema::table('document_request_types', function(Blueprint $blueprint){
            $blueprint->dropColumn('has_upload');
        });
    }
}
