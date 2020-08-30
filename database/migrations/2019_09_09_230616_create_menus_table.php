<?php


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('menu', 150);
            $table->string('slug', 150)->unique();
            $table->unsignedInteger('padre')->default(0);
            $table->smallInteger('orden')->default(0);
            $table->boolean('activo')->default(1);
            $table->string('descripcion', 150)->nullable();           
            $table->string('ruta', 50);
            $table->string('ajax', 2)->nullable();
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
        Schema::dropIfExists('menus');
    }
}