<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Nullable;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->integerIncrements('DocumentID')->unsigned();
            $table->unsignedInteger('DocumentTypeID');
            $table->unsignedInteger('HospitalID')->nullable();
            $table->unsignedInteger('DoctorID')->nullable();
            $table->unsignedInteger('LaboratoryID')->nullable();
            $table->unsignedInteger('PatientID')->nullable();
            $table->unsignedInteger('AmbulanceID')->nullable();
            $table->unsignedInteger('InsuranceCompanyID')->nullable();
            $table->string('DocumentFile',250);
            $table->enum('Status',['Active','Inactive'])->default('Active');

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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('documents');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
