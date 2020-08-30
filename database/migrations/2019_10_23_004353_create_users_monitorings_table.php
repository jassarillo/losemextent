<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersMonitoringsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_monitorings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_users')->nullable();
            $table->string('token',200);
            $table->integer('login')->nullable();
            $table->integer('intentos')->nullable();
            $table->integer('valid_password')->nullable();
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
        Schema::dropIfExists('users_monitorings');
    }
}
