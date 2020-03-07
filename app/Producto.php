<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    //
    public $timestamps = false;

    protected $fillable = ['image_producto','nombre','local','negocio','presentacion','cantidad','stock','pedido','codigo'];
}
