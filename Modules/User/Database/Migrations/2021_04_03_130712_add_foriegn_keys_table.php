<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForiegnKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('patients') && Schema::hasTable('blood_groups')) {
            Schema::table('patients', function (Blueprint $table) {
                $table->foreign('BloodGroupID')
                    ->references('BloodGroupID')
                    ->on('blood_groups')
                    ->onDelete('SET NULL');
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
        Schema::table('patients', function (Blueprint $table) {
            $table->dropForeign(['BloodGroupID']);
        });
        
    }
}
