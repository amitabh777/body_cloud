<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForiegnKeyDoctorSectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doctor_sectors', function (Blueprint $table) {
            $table->foreign('DoctorID')
                ->references('DoctorID')
                ->on('doctors')
                ->onDelete('cascade');

            $table->foreign('SectorID')
                ->references('MedicalSectorID')
                ->on('medical_sectors')
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
        Schema::table('doctor_sectors', function (Blueprint $table) {
            $table->dropForeign(['DoctorID']);
        });
        Schema::table('doctor_sectors', function (Blueprint $table) {
            $table->dropForeign(['SectorID']);
        });
    }
}
