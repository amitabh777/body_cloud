<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateInsuranceBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insurance_branches', function (Blueprint $table) {
            $table->integerIncrements('InsuranceBranchID')->unsigned();
            $table->unsignedInteger('InsuranceCompanyID')->nullable();
            $table->string('InsuranceBranchName', 120);
            $table->string('InsuranceBranchInfo', 200);
            $table->string('InsuranceBranchAddress', 200);
            $table->enum('Status', ['Active', 'Inactive'])->default('Active');
            $table->foreign('InsuranceCompanyID')
                ->references('InsuranceCompanyID')
                ->on('insurance_companies')->OnDelete('cascade');
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
        Schema::dropIfExists('insurance_branches');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
