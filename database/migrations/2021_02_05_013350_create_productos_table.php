<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('idProducto');
            $table->unsignedBigInteger('idVendedor');
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->integer('cantidad');
            $table->enum('estado', ['ACTIVO', 'INACTIVO'])->default('INACTIVO');
            $table->foreign('idVendedor')->references('id')->on('users')->onDelete('RESTRICT')->onUpdate('CASCADE');
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
        Schema::dropIfExists('productos');
    }
}
