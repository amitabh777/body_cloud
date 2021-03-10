<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUserRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('user_roles')) {
            Schema::create('user_roles', function (Blueprint $table) {
                $table->integerIncrements('UserRoleID')->unsigned();
                $table->unsignedInteger('RoleID');
                $table->unsignedInteger('UserID');
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
        Schema::dropIfExists('user_roles');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
