<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHospitalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Hospitals', function (Blueprint $table) {
            $table->integerIncrements('HospitalID')->unsigned();
            $table->unsignedInteger('UserID');
            $table->string('HospitalName',100);
            $table->string('HospitalInfo',300);
            $table->string('HospitalProfileImage',100)->nullable();
            $table->string('HospitalContactName',100);
            $table->string('HospitalWebsite',100)->nullable();
            $table->string('HospitalBankAccountNo',100)->nullable();
            $table->string('HospitalBankName',100)->nullable();
            $table->float('HospitalMinReservationCharge')->nullable();
            $table->enum('Status',['Active','Inactive'])->default('Active');

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
        Schema::dropIfExists('Hospitals');
    }
}
