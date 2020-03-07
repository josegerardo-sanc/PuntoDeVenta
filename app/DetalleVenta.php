<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    public $timestamps = false;
    protected $fillable = ['tipo_venta','id_produto','id_venta','cantidad','precio'];

}
