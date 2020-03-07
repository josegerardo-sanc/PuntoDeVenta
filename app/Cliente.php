<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{

    
    public $timestamps = false;
    protected $fillable = ['cliente','tipo','telefono','direccion_p','img_cliente','negocio','direccion_n','img_negocio'];

}

