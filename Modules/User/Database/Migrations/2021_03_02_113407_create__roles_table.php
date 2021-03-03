<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('Roles')) {
            Schema::create('Roles', function (Blueprint $table) {
                $table->integerIncrements('RoleID')->unsigned();
                $table->string('RoleName', 50);
                $table->string('RoleSlug',50);
                $table->unsignedInteger('ParentRoleID')->nullable()->comment('parent role');
                // $table->timestamps();
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
        Schema::dropIfExists('Roles');
    }
}
