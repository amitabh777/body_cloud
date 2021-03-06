<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->integerIncrements('UserID')->unsigned();
                $table->string('UniqueID',20)->unique()->comment('pattern string');
                $table->unsignedInteger('ParentID')->nullable()->comment('parent user id, in case of staff user');
                $table->string('Email',150)->unique();
                $table->string('Phone',15)->unique();
                $table->string('Password',250);
                $table->string('Address',350)->nullable();
                $table->enum('Status',['Active','Inactive'])->default('Inactive');
                $table->string('DeviceType',30)->nullable();
                $table->string('DeviceToken',50)->nullable();
                $table->mediumInteger('Otp')->unsigned()->nullable();
                $table->string('api_token')
                        ->unique()
                        ->nullable()
                        ->default(null);
                $table->timestamp('email_verified_at')->nullable();                
                $table->rememberToken();
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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('users');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
