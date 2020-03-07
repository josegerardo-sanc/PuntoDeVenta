<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetallePrecompra extends Model
{
    //
    public $timestamps = false;

    protected $fillable = ['id_produto','cantidad'];

}
