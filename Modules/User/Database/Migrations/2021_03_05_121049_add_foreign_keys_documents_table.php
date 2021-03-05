<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
        Schema::table('documents', function (Blueprint $table) {
            $table->dropForeign(['DocumentTypeID','HospitalID','DoctorID','LaboratoryID','PatientID','InsuranceCompanyID']);
        });
    }
}
