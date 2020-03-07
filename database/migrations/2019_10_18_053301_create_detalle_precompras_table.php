<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetallePrecomprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_precompras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_producto');
            $table->unsignedBigInteger('id_precompra');
            $table->string('cantidad');
            $table->foreign('id_producto')->references('id')->on('productos');
            $table->foreign('id_precompra')->references('id')->on('precompras');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_precompras');
    }
}
