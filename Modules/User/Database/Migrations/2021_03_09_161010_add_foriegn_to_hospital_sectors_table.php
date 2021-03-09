<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForiegnToHospitalSectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hospital_sectors', function (Blueprint $table) {
            $table->foreign('MedicalSectorID')
            ->references('MedicalSectorID')
            ->on('medical_sectors')
            ->onDelete('cascade');

            $table->foreign('HospitalID')
            ->references('HospitalID')
            ->on('hospitals') 
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
        Schema::table('hospital_sectors', function (Blueprint $table) {
            $table->dropForeign(['HospitalID']);
            $table->dropForeign(['MedicalSectorID']);
        });
    }
}
