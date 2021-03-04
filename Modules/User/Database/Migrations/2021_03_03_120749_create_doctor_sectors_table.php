<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateDoctorSectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('DoctorSectors')) {
            Schema::create('DoctorSectors', function (Blueprint $table) {
                $table->integerIncrements('DoctorSectorID')->unsigned();
                $table->integer('DoctorID')->unsigned();
                $table->integer('SectorID')->unsigned();
                $table->timestamp('CreatedAt')->nullable();
                $table->timestamp('UpdatedAt')->nullable();
                $table->foreign('DoctorID')
                    ->references('DoctorID')
                    ->on('Doctors')->OnDelete('cascade');
                $table->foreign('SectorID')
                    ->references('MedicalSectorID')
                    ->on('MedicalSectors')->OnDelete('cascade');
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
        Schema::dropIfExists('DoctorSectors');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
