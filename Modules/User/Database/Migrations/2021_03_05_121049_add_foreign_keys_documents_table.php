<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddForeignKeysDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('documents') && Schema::hasTable('document_types')) {
            Schema::table('documents', function (Blueprint $table) {
                $table->foreign('DocumentTypeID')
                    ->references('DocumentTypeID')
                    ->on('document_types')
                    ->onDelete('cascade');

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

                $table->foreign('PatientID')
                    ->references('PatientID')
                    ->on('patients')
                    ->onDelete('cascade');

                $table->foreign('InsuranceCompanyID')
                    ->references('InsuranceCompanyID')
                    ->on('insurance_companies')
                    ->onDelete('cascade');
                $table->foreign('AmbulanceID')
                    ->references('AmbulanceID')
                    ->on('ambulances')
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
        Schema::table('documents', function (Blueprint $table) {
            $table->dropForeign(['DocumentTypeID']);
            $table->dropForeign(['HospitalID']);
            $table->dropForeign(['DoctorID']);
            $table->dropForeign(['LaboratoryID']);
            $table->dropForeign(['PatientID']);
            $table->dropForeign(['InsuranceCompanyID']);
            $table->dropForeign(['AmbulanceID']);
            });
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
