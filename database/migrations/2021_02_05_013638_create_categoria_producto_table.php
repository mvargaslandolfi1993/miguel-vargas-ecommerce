<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriaProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categoria_producto', function (Blueprint $table) {
            $table->unsignedBigInteger('idCategoria')->nullable();
            $table->unsignedBigInteger('idProducto')->nullable();
            $table->foreign('idCategoria')->references('idCategoria')->on('categorias')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->foreign('idProducto')->references('idProducto')->on('productos')->onDelete('RESTRICT')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categoria_producto');
    }
}
