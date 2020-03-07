<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('id_cliente')->nullable();
            $table->unsignedBigInteger('id_usuario');
            $table->string('numerofactura');
            $table->string('fecha');
            $table->string('hora');
            $table->string('importe');
            $table->enum('venta', ['contado', 'credito']);
            $table->enum('status_corte', ['no', 'yes']);
            $table->string('fecha_corte')->nullable();
            $table->string('quien_r_corte')->nullable();
            $table->foreign('id_usuario')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
}
