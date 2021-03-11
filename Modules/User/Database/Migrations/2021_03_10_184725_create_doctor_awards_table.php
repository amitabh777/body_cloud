<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorAwardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_awards', function (Blueprint $table) {
            $table->increments('DoctorAwardID')->unsigned();
            $table->integer('DoctorID')->unsigned();
            $table->string('AwardName');
            $table->string('AwardFor');
            $table->enum('Status',['Active','Inactive']);
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
        Schema::dropIfExists('doctor_awards');
    }
}
