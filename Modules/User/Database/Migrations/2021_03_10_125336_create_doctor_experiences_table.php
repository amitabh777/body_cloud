<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_experiences', function (Blueprint $table) {
            $table->increments('DoctorExperienceID')->unsigned();
            $table->unsignedInteger('DoctorID');
            $table->string('Institute');
            $table->date('ExperienceFrom');
            $table->date('ExperienceTo');
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
        Schema::dropIfExists('doctor_experiences');
    }
}
