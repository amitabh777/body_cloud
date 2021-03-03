<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreatePatientInsuranceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_insurance', function (Blueprint $table) {
            $table->integerIncrements('PatientInsuranceID')->unsigned();
            $table->string('InsuranceNo', 100);
            $table->unsignedInteger('InsuranceCompanyID')->nullable();
            $table->unsignedInteger('InsuranceCategoryID');
            $table->string('InsuranceCompanyName',150)->nullable();
            $table->enum('Status',['Active','Inactive'])->default('Active');
            $table->timestamp('CreatedAt')->nullable();
            $table->timestamp('UpdatedAt')->nullable(); 
            $table->foreign('InsuranceCompanyID')
            ->references('InsuranceCompanyID')
            ->on('insurance_companies');
            $table->foreign('InsuranceCategoryID')
            ->references('InsuranceCategoryID')
            ->on('insurance_categories');
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
        Schema::dropIfExists('patient_insurance');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
