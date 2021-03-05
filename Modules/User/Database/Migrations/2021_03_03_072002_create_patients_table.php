<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('patients')) {
            Schema::create('patients', function (Blueprint $table) {
                $table->integerIncrements('PatientID')->unsigned();
                $table->unsignedInteger('UserID');
                $table->string('PatientName', 100);
                $table->enum('PatientGender', ['Male', 'Female']);
                $table->date('PatientDOB');
                $table->integer('BloodGroupID')->unsigned()->nullable();
                $table->float('PatientHeight');
                $table->float('PatientWeight');
                $table->string('PatientChronicDisease', 200)->nullable();
                $table->string('PatientPermanentMedicines', 500)->nullable();
                $table->string('EmergencyContactNo', 15);
                $table->enum('Status', ['Active', 'Inactive']);
                $table->timestamp('CreatedAt')->nullable();
                $table->timestamp('UpdatedAt')->nullable();                      
                $table->foreign('UserID')
                    ->references('UserID')
                    ->on('users')
                    ->onDelete('cascade');    
                    // $table->foreign('BloodGroupID')
                    // ->references('BloodGroupID')
                    // ->on('blood_groups')
                    // ->onDelete('SET NULL');                   
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
        Schema::dropIfExists('patients');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
