<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddForiegnKeysVisitingHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visiting_hours', function (Blueprint $table) {
            $table->foreign('HospitalID')
            ->references('HospitalID')
            ->on('hospitals')
            ->onDelete('cascade');
            $table->foreign('DoctorID')
            ->references('DoctorID')
            ->on('doctors')
            ->onDelete('cascade');
            $table->foreign('LaboratoryID')
            ->references('LaboratoryID')
            ->on('laboratories')
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
        Schema::table('visiting_hours', function (Blueprint $table) {
            $table->dropForeign(['HospitalID', 'DoctorID', 'LaboratoryID']);
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
