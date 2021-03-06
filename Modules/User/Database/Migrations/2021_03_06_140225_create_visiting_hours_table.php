<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitingHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visiting_hours', function (Blueprint $table) {
            $table->integerIncrements('VisitingHourID')->unsigned();
            $table->integer('HospitalID')->unsigned()->nullable();
            $table->integer('DoctorID')->unsigned()->nullable();
            $table->integer('LaboratoryID')->unsigned()->nullable();
            $table->string('VisitingDay', 20);
            $table->time('VisitingStartTime');
            $table->time('VisitingEndTime');
            $table->enum('VisitingSlot', ['Morning', 'Noon', 'Evening']);
            $table->boolean('IsAvailable');
            $table->enum('Status', ['Active', 'Inactive'])->nullable('Active');
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
        Schema::dropIfExists('visiting_hours');
    }
}
