<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('image')->default(null)->nullable();
            $table->string('name');
            $table->string('occupation')->default(null)->nullable();
            $table->string('company')->default(null)->nullable();
            $table->string('address')->default(null)->nullable();
            $table->date('birth_date')->default(null)->nullable();
            $table->string('phone')->default(null)->nullable();
            $table->enum('user_type', ['standard','plus']);
            $table->enum('gender', ['Male','Female'])->default(null)->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
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