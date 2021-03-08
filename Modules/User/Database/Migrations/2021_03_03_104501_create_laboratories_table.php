<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateLaboratoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laboratories', function (Blueprint $table) {
            $table->integerIncrements('LaboratoryID')->unsigned();
            $table->integer('UserID')->unsigned();
            $table->string('LaboratoryInfo')->nullable();
            $table->string('LaboratoryProfileImage',200)->nullable();
            $table->string('LaboratoryCompanyName',100);
            $table->string('LaboratoryWebsite',150)->nullable();
            $table->string('LaboratoryBankAccountNo',100)->nullable();
            $table->string('LaboratoryBankName',100)->nullable();
            $table->float('LaboratoryMinReservationCharge')->nullable();
            $table->enum('Status',['Active', 'Inactive'])->default('Active');
            $table->timestamp('CreatedAt')->nullable();
            $table->timestamp('UpdatedAt')->nullable();  
            $table->foreign('UserID')
            ->references('UserID')
            ->on('users')
            ->onDelete('cascade');        

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
        Schema::dropIfExists('laboratories');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
