<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_ventas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('tipo_venta', ['local', 'cliente']);
            $table->unsignedBigInteger('id_producto');
            $table->unsignedBigInteger('id_venta');
            $table->string('cantidad');
            $table->string('precio');
            $table->foreign('id_producto')->references('id')->on('productos');
            $table->foreign('id_venta')->references('id')->on('ventas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_ventas');
    }
}
