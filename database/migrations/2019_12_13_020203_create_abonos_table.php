<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbonosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abonos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_ventas');
            $table->string('abono');
            $table->string('fecha');
            $table->enum('status_corte',['no','yes']);
            $table->foreign('id_ventas')->references('id')->on('ventas');
            $table->string('fecha_corte')->nullable();
            $table->string('quien_r_corte')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('abonos');
    }
}
