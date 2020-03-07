<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    //
    public $timestamps = false;
    protected $fillable = ['id_cliente','numerofactura','fecha','importe'];
}
