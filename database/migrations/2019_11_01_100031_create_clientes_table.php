<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cliente');
            $table->enum('tipo', ['no', 'yes']);
            $table->enum('status', ['yes', 'no']);
            $table->string('telefono');
            $table->string('direccion_p');
            $table->string('img_cliente');
            $table->string('negocio')->nullable();
            $table->string('direccion_n')->nullable();
            $table->string('img_negocio');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
