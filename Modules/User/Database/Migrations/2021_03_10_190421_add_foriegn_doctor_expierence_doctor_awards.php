<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForiegnDoctorExpierenceDoctorAwards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('doctor_experiences')) {
            Schema::table('doctor_experiences', function (Blueprint $table) {
                $table->foreign('DoctorID')
                    ->references('DoctorID')
                    ->on('doctors')
                    ->onDelete('cascade');
            });
        }
        if (Schema::hasTable('doctor_awards')) {
            Schema::table('doctor_awards', function (Blueprint $table) {
                $table->foreign('DoctorID')
                    ->references('DoctorID')
                    ->on('doctors')
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
        if (Schema::hasTable('doctor_experiences')) {
            Schema::table('doctor_experiences', function (Blueprint $table) {
                $table->dropForeign(['DoctorID']);
            });
        }
        if (Schema::hasTable('doctor_awards')) {
            Schema::table('doctor_awards', function (Blueprint $table) {
                $table->dropForeign(['DoctorID']);
            });
        }
    }
}
