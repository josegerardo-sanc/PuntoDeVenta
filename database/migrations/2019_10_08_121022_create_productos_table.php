<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->string('codigo');
            $table->enum('status', ['yes', 'no']);
            $table->string('image_producto');
            $table->string('nombre');
            $table->string('local');
            $table->string('negocio');
            $table->string('presentacion');
            $table->string('cantidad');
            $table->string('stock');
            $table->integer('pedido')->nullable();
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
