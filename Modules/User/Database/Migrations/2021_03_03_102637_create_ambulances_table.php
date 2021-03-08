<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateAmbulancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('ambulances')) {
            Schema::create('ambulances', function (Blueprint $table) {
                $table->integerIncrements('AmbulanceID')->unsigned();
                $table->unsignedInteger('UserID');
                $table->string('AmbulanceNumber', 30);
                $table->string('AmbulanceContactName', 15);
                $table->string('AmbulanceProfileImage',150)->nullable();
                $table->integer('HospitalID')->nullable();
                $table->float('AmbulanceMinReservationCharge')->nullable();
                $table->enum('Status', ['Active', 'Inactive'])->default('Active');
                $table->timestamp('CreatedAt')->nullable();
                $table->timestamp('UpdatedAt')->nullable();
                $table->foreign('UserID')
                    ->references('UserID')
                    ->on('users')
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
        Schema::dropIfExists('ambulances');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
