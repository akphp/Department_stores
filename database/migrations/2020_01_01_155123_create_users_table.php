<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username')->unique()->nullable();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            // $table->rememberToken();
            $table->string('verified')->default(0);
            $table->string('verification_token')->nullable();
             $table->string('password')->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('mobile')->unique()->nullable();
            $table->tinyInteger('is_active')->default(1)->comment('0 => inactive , 1 => active');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
