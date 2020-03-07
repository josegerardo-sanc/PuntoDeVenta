<?php

namespace App\Classes;

use App\Venta;
use App\Precompra;
use App\DetallePrecompra;
use App\Producto;
use Illuminate\Support\Facades\DB;

class Metodos
{

  function __construct()
  {

    date_default_timezone_set('America/Mexico_City');
    if(!isset($_SESSION))
    {
    session_start();
    }
    define('metodo', 'AES-128-ECB');
    define('key', 'password_pas');
  }

 function Generador()
{
$cadena="0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
$longitud=strlen($cadena)-1;

$codigo= substr($cadena,rand(0,$longitud),1).
         substr($cadena,rand(0,$longitud),1).
         substr($cadena,rand(0,$longitud),1).
         substr($cadena,rand(0,$longitud),1).
         substr($cadena,rand(0,$longitud),1).
         substr($cadena,rand(0,$longitud),1).
         substr($cadena,rand(0,$longitud),1).
         substr($cadena,rand(0,$longitud),1).
         substr($cadena,rand(0,$longitud),1).
         substr($cadena,rand(0,$longitud),1);

return $codigo;

}
  function newFactura()
  {
    $consulta="";
    $consulta=DB::select('select numerofactura from ventas union all  select numeroFactura from precompras');

    $arreglo=array();
    $arreglo=$consulta;

    $code=metodos::Generador();
    for($i=0; $i<count($arreglo); $i++)// si tengo valores em mi arreglo entra el ciclo for de lo contraio se agregaria un clave
       {
        if($code==$arreglo[$i])
        {
             $code=metodos::Generador();
             $i=-1;
        }
       }
    return $code;
  }

  function eliminarPrecompra(){

    if(isset($_SESSION['precompra'])){
      $data_DetallePre=DetallePrecompra::where('id_precompra',$_SESSION['precompra'])->get();
      foreach ($data_DetallePre as $key => $value) {
          # code...
          Producto::where('id',$value->id_producto)->decrement('pedido',$value->cantidad);
      }
      DB::table('detalle_precompras')->where('id_precompra',$_SESSION['precompra'])->delete();
      DB::table('precompras')->where('numeroFactura',$_SESSION['numFactura'])->delete();


      unset($_SESSION['carrito']);
      unset($_SESSION['precompra']);
      unset($_SESSION['id_cliente']);
      unset($_SESSION['nombre_id_cliente']);
     }
  }

}
