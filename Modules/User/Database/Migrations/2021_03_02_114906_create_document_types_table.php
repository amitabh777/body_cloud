<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateDocumentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_types', function (Blueprint $table) {
            $table->integerIncrements('DocumentTypeID')->unsigned();
            $table->string('DocumentTypeName',70);
            $table->string('DocumentTypeDesc',100);
            $table->enum('Status',['Active','Inactive'])->default('Active');

            $table->timestamp('CreatedAt')->nullable();
            $table->timestamp('UpdatedAt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('document_types');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
