<?php

namespace App\Http\Controllers;

use App\Producto;
use App\Precompra;
use App\DetallePrecompra;

use Illuminate\Http\Request;
use App\Classes\Metodos;
use DateTime;
use Exception;

class PrecompraController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('venta.carrito');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

public function Carrito(Request $request){

    $metodos=new Metodos();
    $data_post=$request->except('_token');
    switch ($data_post['btn_accion']) {
        case 'addCarrito':
            # code...
            $encontrado_producto=false;
            $indice=0;

            if(is_numeric(openssl_decrypt($data_post['clave'],metodo,key)))
            {
                $clave_post=openssl_decrypt($data_post['clave'],metodo,key);

                $MODEL_producto=Producto::findOrFail($clave_post);
                if(!isset($data_post['ajax']))
                {
                  $disponible_almacen=$MODEL_producto->cantidad - $MODEL_producto->pedido;
                  if(!($disponible_almacen>0)){
                      return redirect('/venta')->with('status', 'Lo sentimos este producto ya esta agotado!!');
                  }
                }

                if(isset($_SESSION['carrito']))
                {
                    foreach ($_SESSION['carrito'] as $key => $carrito) {
                        # code...
                        if($MODEL_producto->id==openssl_decrypt($_SESSION['carrito'][$key]['ID'],metodo,key)){
                            $indice=$key;
                            $encontrado_producto=true;
                            break;
                        }
                    }

                }
                if($encontrado_producto){
                    $data_DetallePrecon_ajax=DetallePrecompra::where('id_producto',$clave_post)
                    ->where('id_precompra',$_SESSION['precompra'])->first();
                     $new_cantidad=1;

                   if(isset($data_post['ajax']))
                   {

                     $new_cantidad=is_numeric($data_post['cantidad'])?$data_post['cantidad']:1;
                     if($data_post['cantidad']==0)
                        {
                            //eliminacion de la fila de la variable de session
                            $arreglo=$_SESSION['carrito'];
                            unset($arreglo[$indice]);
                            $arreglo=array_values($arreglo);
                            $_SESSION['carrito']=$arreglo;
                            //eliminacion de la fila
                          $data_DetallePrecon_ajax=DetallePrecompra::where('id_producto',$clave_post)
                          ->where('id_precompra',$_SESSION['precompra'])->delete();

                          $pedidos=DetallePrecompra::where('id_producto',$clave_post)
                          ->sum('cantidad');
                           Producto::where('id',$MODEL_producto->id)->update(['pedido'=>$pedidos]);

                          if(empty($_SESSION['carrito'])){
                            Precompra::where('id',$_SESSION['precompra'])->delete();
                            unset($_SESSION['carrito']);
                            unset($_SESSION['precompra']);
                            unset($_SESSION['id_cliente']);
                            unset($_SESSION['nombre_id_cliente']);
                             return json_encode(array("data"=>[],"respuesta"=>'eliminar_fila'));
                            }
                            return json_encode(array("data"=>$_SESSION['carrito'],"respuesta"=>'eliminar_fila'));
                        }
                     $temporal_descuento=$MODEL_producto->pedido - $data_DetallePrecon_ajax->cantidad;
                     $almacen=$MODEL_producto->cantidad - $temporal_descuento;
                     $solicitud_bool=true;
                     if(!($almacen>=$new_cantidad))
                     {
                       $new_cantidad=$almacen;
                       $solicitud_bool=false;
                     }
                    $_SESSION['carrito'][$indice]['CANTIDAD']=$new_cantidad;
                   }
                   else{
                    $new_cantidad=$data_DetallePrecon_ajax->cantidad + 1;
                    $_SESSION['carrito'][$indice]['CANTIDAD']=$_SESSION['carrito'][$indice]['CANTIDAD']+1;
                   }
                   DetallePrecompra::where('id_producto',$clave_post)
                   ->where('id_precompra',$_SESSION['precompra'])
                   ->update(['cantidad'=>$new_cantidad]);
                }
                else{

                  if(!isset($_SESSION['precompra'])){
                    $date=new DateTime;
                    $date->modify('+10 minute');

                    $newFactura=isset($_SESSION['numFactura'])?$_SESSION['numFactura']:$_SESSION['numFactura']=$metodos->newFactura();

                    $Modelprecompra=new Precompra;
                    $Modelprecompra->fecha=$date;
                    $Modelprecompra->numeroFactura=$newFactura;
                    $Modelprecompra->save();

                    $_SESSION['precompra']=$Modelprecompra->id;
                  }

                   $MODEL_detallePre=new DetallePrecompra;
                   $MODEL_detallePre->id_producto=$MODEL_producto->id;
                   $MODEL_detallePre->id_precompra=$_SESSION['precompra'];
                   $MODEL_detallePre->cantidad=1;
                   $MODEL_detallePre->save();

                  $carrito=array(
                    "ID"=>openssl_encrypt($MODEL_producto->id,metodo,key),
                    "NOMBRE"=>$MODEL_producto->nombre,
                    "PRESENTACION"=>$MODEL_producto->presentacion,
                    "CANTIDAD"=>1,
                    "PRECIO"=>$MODEL_producto->local,
                    "IMG"=>$MODEL_producto->image_producto,
                    "VENTA"=>0
                  );

                  $_SESSION['carrito'][]=$carrito;
                }
                $pedidos=DetallePrecompra::where('id_producto',$clave_post)
                ->sum('cantidad');
                 Producto::where('id',$MODEL_producto->id)->update(['pedido'=>$pedidos]);

                if(isset($data_post['ajax'])){
                    //espero que mi update de la tabla detallePrecompra para
                   // luego marcharme alway when exist ajax
                   return json_encode(array("data"=>$_SESSION['carrito'],"respuesta"=>$solicitud_bool));
                }
                 return redirect('/venta');
            }
            break;

        default:
            # code...
            break;
    }

}

public function TipoVenta (Request $request)
{
    $metodos=new Metodos();

    $Data_Post=$request->except('_token');
    $MODEL_Producto="";
    $indice=0;
    if(is_numeric(openssl_decrypt($Data_Post['clave'],metodo,key)))
    {
     $Post_clave_TipVenta=openssl_decrypt($Data_Post['clave'],metodo,key);
     try {
         //code...
      $MODEL_Producto=Producto::findOrFail($Post_clave_TipVenta);
     } catch (Exception $e) {
         return json_encode(array('resultado'=>false));
     }
    }

    foreach ($_SESSION['carrito'] as $key => $producto) {
        # code...
        if(openssl_decrypt($producto['ID'],metodo,key)==$Post_clave_TipVenta){
            $indice=$key;
            break;
        }
    }
    switch ($Data_Post['TipoVenta']) {
        case 0:
            # code...
            $_SESSION['carrito'][$indice]['PRECIO']=$MODEL_Producto->local;
            $_SESSION['carrito'][$indice]['VENTA']=0;
            return json_encode(array("data"=>$_SESSION['carrito'],"resultado"=>true));
            break;

        case 1:
            # code...
            $_SESSION['carrito'][$indice]['PRECIO']=$MODEL_Producto->negocio;
            $_SESSION['carrito'][$indice]['VENTA']=1;
            return json_encode(array("data"=>$_SESSION['carrito'],"resultado"=>true));
            break;

        default:
            # code..

            return json_encode(array('resultado'=>false));
           break;
    }


}


public function TimeIsUpPrecompra(Request $request){
$metodos=new Metodos();

    if(isset($_SESSION['precompra']))
      {

       $data=$request->all();

       switch ($data['action']) {
                case 'validacion':
                # code...
                $Model_timePrecompra=Precompra::where('id',$_SESSION['precompra'])
                ->where('numeroFactura',$_SESSION['numFactura'])->first();

                $fecha_actual = strtotime(date("d-m-Y H:i:00",time()));
                $fecha_entrada = strtotime($Model_timePrecompra->fecha);

                #si es true lo convierto false y viceversa
                       $arreglo=array("precompra"=>true,"SolicitarConfirmacion"=>false);
                if(!($fecha_entrada>=$fecha_actual))
                    {
                        $arreglo=array("precompra"=>true,"SolicitarConfirmacion"=>true);
                    }
                return($arreglo);

                break;
                case 'confirmacion':
                # code... la confirmacion del usuario para continuar
                # con la compra..
                if($data['opcion_']=="true"){
                    $date=new DateTime;
                    $date->modify('+10 minute');

                $Model_timePrecompra=Precompra::where('id',$_SESSION['precompra'])
                ->where('numeroFactura',$_SESSION['numFactura'])->update(['fecha'=>$date]);
                      return(array("continuarCompra"=>true));
                 }
                 else{
                     $metodos->eliminarPrecompra();
                     return(array("continuarCompra"=>false));
                 }
                break;

                default:
               # code...
               break;
       }

      }
else{
    return(array("precompra"=>false));
}

}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Precompra  $precompra
     * @return \Illuminate\Http\Response
     */
    public function show(Precompra $precompra)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Precompra  $precompra
     * @return \Illuminate\Http\Response
     */
    public function edit(Precompra $precompra)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Precompra  $precompra
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Precompra $precompra)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Precompra  $precompra
     * @return \Illuminate\Http\Response
     */
    public function destroy(Precompra $precompra)
    {
        //
    }
}
