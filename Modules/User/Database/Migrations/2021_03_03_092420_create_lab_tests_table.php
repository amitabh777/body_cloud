<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LabTests', function (Blueprint $table) {
            $table->integerIncrements('LabTestID')->unsigned();
            $table->string('LabTestName',100);
            $table->string('LabTestDesc',200)->nullable();
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
        Schema::dropIfExists('LabTests');
    }
}
