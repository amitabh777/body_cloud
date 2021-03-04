<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInsuranceCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('InsuranceCategories', function (Blueprint $table) {
            $table->integerIncrements('InsuranceCategoryID')->unsigned();
            $table->string('InsuranceCategoryName',100);
            $table->string('InsuranceCategoryDesc',150)->nullable();
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
        Schema::dropIfExists('InsuranceCategories');
    }
}
