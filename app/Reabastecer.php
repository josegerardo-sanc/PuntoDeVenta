<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reabastecer extends Model
{
    //
    public $timestamps = false;
    protected $fillable = ['id_produto','cantidad','fecha'];

}
