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
            $table->string('username',32)->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->smallInteger('logged_flag')->default(0);
            $table->smallInteger('role')->default(0);
            $table->string('name')->nullable();
            $table->date('birthday')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('image')->nullable();
            $table->string('phone',20)->nullable();
            $table->boolean('logout')->default(false);
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
