<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('Doctors')) {
            Schema::create('Doctors', function (Blueprint $table) {
                $table->integerIncrements('DoctorID')->unsigned();
                $table->unsignedInteger('UserID');
                $table->string('DoctorName', 100);
                $table->string('DoctorInfo', 200);
                $table->string('DoctorProfileImage', 150)->nullable();
                $table->unsignedInteger('HospitalID')->nullable();
                $table->string('DoctorWebsite', 100)->nullable();
                $table->string('DoctorBankAccountNo', 100)->nullable();
                $table->string('DoctorBankName', 100)->nullable();
                $table->float('DoctorMinReservationCharge', 100)->nullable();
                $table->enum('Status', ['Active', 'Inactive'])->default('Active');
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
        Schema::dropIfExists('Doctors');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
