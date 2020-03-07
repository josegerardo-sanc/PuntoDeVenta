<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class abono extends Model
{
    //
    public $timestamps = false;
    protected $fillable = ['id_venta','abono','fecha'];
}
