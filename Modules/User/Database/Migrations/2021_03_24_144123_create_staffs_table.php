<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateStaffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staffs', function (Blueprint $table) {
            $table->increments('StaffID')->unsigned();
            $table->unsignedInteger('UserID');
            $table->string('FirstName',50);
            $table->string('LastName',50)->nullable();
            $table->string('ProfileImage', 150)->nullable();
            $table->string('Designation', 70)->nullable();
            $table->timestamp('CreatedAt')->nullable();
            $table->timestamp('UpdatedAt')->nullable();
            $table->foreign('UserID')
            ->references('UserID')
            ->on('users')
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
        Schema::dropIfExists('staffs');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
