<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateInsuranceCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('insurance_companies')){
        Schema::create('insurance_companies', function (Blueprint $table) {
            $table->integerIncrements('InsuranceCompanyID')->unsigned();
            $table->integer('UserID')->unsigned();
            $table->string('InsuranceCompanyName',100);
            $table->string('InsuranceCompanyInfo',100)->nullable();
            $table->string('InsuranceCompanyProfileImage',150)->nullable();
            $table->string('InsuranceCompanyWebsite',100)->nullable();
            $table->string('InsuranceCompanyBankAccountNo',100)->nullable();
            $table->string('InsuranceCompanyBankName',100)->nullable();
            $table->enum('Status',['Active','Inactive'])->default('Active');
            $table->timestamp('CreatedAt')->nullable();
            $table->timestamp('UpdatedAt')->nullable();  
            $table->foreign('UserID')
            ->references('UserID')
            ->on('users')
            ->onDelete('cascade');  
        });
    }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('insurance_companies');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
