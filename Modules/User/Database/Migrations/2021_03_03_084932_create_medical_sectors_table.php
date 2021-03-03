<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicalSectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('medical_sectors')) {
            Schema::create('medical_sectors', function (Blueprint $table) {
                $table->integerIncrements('MedicalSectorID')->unsigned();
                $table->string('MedicalSectorName', 100);
                $table->string('MedicalSectorDesc', 200)->nullable();
                $table->enum('Status', ['Active', 'Inactive']);
                $table->timestamp('CreatedAt')->nullable();
                $table->timestamp('UpdatedAt')->nullable();
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
        Schema::dropIfExists('medical_sectors');
    }
}
