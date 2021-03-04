<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBloodGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('BloodGroups', function (Blueprint $table) {
            $table->integerIncrements('BloodGroupID')->unsigned();
            $table->string('BloodGroupName',30);
            $table->string('BloodGroupDesc',100);
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
        Schema::dropIfExists('BloodGroups');
    }
}
