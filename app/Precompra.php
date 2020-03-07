<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Precompra extends Model
{
     public $timestamps = false;

     protected $fillable = ['fecha','numeroFactura'];


}
