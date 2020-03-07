<?php

namespace App\Http\Controllers;

use App\Venta;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\URL;
use PhpParser\Node\Stmt\Return_;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\Precompra;
use App\DetallePrecompra;
use App\Cliente;
use App\Producto;
use App\DetalleVenta;

use App\Classes\Metodos;
use DateTime;

use Illuminate\Support\Facades\Auth;

class VentaController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function borrar_producto(){
        $metodos=new Metodos();

        if(is_numeric(openssl_decrypt($_POST['clave'],metodo,key)))
            {
                $indice="";
                $clave_post=openssl_decrypt($_POST['clave'],metodo,key);
                $MODEL_producto=Producto::findOrFail($clave_post);
                foreach ($_SESSION['carrito'] as $key => $carrito) {
                    # code...
                    if($clave_post==openssl_decrypt($_SESSION['carrito'][$key]['ID'],metodo,key)){
                            $indice=$key;
                            break;
                    }
                }
            }
            $arreglo=$_SESSION['carrito'];
            unset($arreglo[$indice]);
            $arreglo=array_values($arreglo);
            $_SESSION['carrito']=$arreglo;

              DetallePrecompra::where('id_producto',$clave_post)
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

            $arre=array("data"=>$_SESSION['carrito'],"respuesta"=>"eliminar_fila");
            return json_encode($arre);
     }


     public function restablecerTipoVenta(){
        if(!isset($_SESSION))
        {
            session_start();
        }
        if(isset($_SESSION['carrito'])){
            $data=$_SESSION['carrito'];
            foreach ($data as $key => $value) {
                # code...
                $data[$key]['VENTA']='0';
            }
            $_SESSION['carrito']=$data;
            //return($_SESSION['carrito']);
            unset($_SESSION['id_cliente']);
            unset($_SESSION['nombre_id_cliente']);
            return redirect('Carrito');

        }
     }

    public function search_cliente(){

        $data="";
        if(!isset($_SESSION))
        {
            session_start();
        }
        if(!is_numeric($_POST['telefono'])){
           return(json_encode(array("data"=>[],"resp"=>2)));
        }
        $telefono=trim($_POST['telefono']);
        $data=Cliente::where('telefono','=',$telefono)->get();
        //deberia haber marcado error ya que la variable data me devuele corchetes vacio []
        //quiere decir que data esta vacio
        if($data!="[]"){
            $_SESSION['nombre_id_cliente']=$data[0]->cliente;
            $_SESSION['id_cliente']=$data[0]->id;

        }
        //return($data[0]->cliente);
        return json_encode(array("data"=>$data,"resp"=>1));
    }

    public function index()
    {
        $productos = Producto::where('status','=','yes')->get();
        return view('venta.index', compact('productos'));
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
        $metodos=new Metodos();

        $venta = $request->except('_token');

        if (isset($venta['btn_venta'])) {

            switch ($venta['btn_venta']) {
                case 'venta':
                    # code...
                if(isset($_SESSION['carrito'])){
                    $TOTAL=0;
                    $venta=new Venta;
                    $venta->id_cliente=isset($_SESSION['id_cliente'])?$_SESSION['id_cliente']:"";
                    $venta->numerofactura=$_SESSION['numFactura'];
                    $id_users=Auth::user()->id;
                    $venta->id_usuario=$id_users;
                    $arreglo_dia_semana=["Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado"];
                    $dia_semana=$arreglo_dia_semana[date('w')];
                    $hora=date("g:i a",strtotime(date('H:i:s')));
                    $hora=$dia_semana." ".$hora;
                    $venta->fecha=date('Y-m-d');
                    $venta->hora=$hora;

                    foreach ($_SESSION['carrito'] as $key => $value) {
                        $TOTAL+=$value['CANTIDAD']*$value['PRECIO'];
                    }
                    $venta->importe=$TOTAL;
                    $venta->venta=$_POST['pago_'];
                    $venta->save();
                    $ID_venta=$venta->id;//id de la table venta
                    foreach ($_SESSION['carrito'] as $key => $value) {
                        $clave_product=openssl_decrypt($value['ID'],metodo,key);
                        $cantidad=$value['CANTIDAD'];
                        $detalleVenta=new DetalleVenta;
                        $detalleVenta->id_venta=$ID_venta;
                        $detalleVenta->id_producto=$clave_product;
                        $detalleVenta->cantidad=$cantidad;

        DB::update("UPDATE productos SET cantidad=cantidad-$cantidad WHERE id='$clave_product'");
                        $detalleVenta->precio=$value['PRECIO'];
                        $detalleVenta->tipo_venta=$value['VENTA']==0?"local":"cliente";
                        $detalleVenta->save();
                    }

                    $metodos->eliminarPrecompra();
                    unset($_SESSION['numFactura']);

                    return redirect('Carrito')->with('status', 'Compra Realizada con exito');

                }else{
                    return redirect('venta');
                }
                    break;

                case 'cancelar':
                    # code...
                   $metodos->eliminarPrecompra();
                   return redirect('Carrito');

                    /*
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
                       }
                        return redirect('Carrito');*/

                    break;
                default:
                    # code...
                    break;
            }
        }
    }


    public function buscarProducto(){
        $metodos=new Metodos();
        $data=request()->all();

        $token=$data['token_'];
        $data_search=trim($data['search']);
       //$result=DB::select("SELECT * FROM productos WHERE MATCH (nombre) AGAINST ('$data_search')");

       $result= DB::table('productos')
                ->where('nombre', 'like',$data_search.'%')
                ->get();

         $productos="";
        foreach ($result as $key => $producto) {
            # code...

            $disponible="";
            $color='badge-primary';
            $disponible=$producto->cantidad - $producto->pedido;
            if($disponible<=0){
                $disponible=0;
               $color='badge-ligth';
            }

            $productos.='
               <div class="col-sm-6 col-md-4 col-lg-3 border">
                    <div class="card m-0 p-0">
                    <img src="/storage/'.$producto->image_producto.'" class="card-img-top tamano"   alt="imagen">
                        <div class="card-body">
                               <h2 class="lead small text-muted d-inline-block"><b>'.$producto->nombre.'</b></h2>
                               <div class="lead small text-muted  d-flex justify-content-between align-items-center">
                                Presentac
                              <span class="badge badge-warning badge-pill">'.$producto->presentacion.'</span>
                              </div>
                               <div class="lead small text-muted  d-flex justify-content-between align-items-center">
                                  Precio
                                <span class="badge badge-primary badge-pill">'.$producto->local.'</span>
                                </div>
                                <div class="lead small text-muted  d-flex justify-content-between align-items-center">
                                  Disponibles
                                  <span class="badge '.$color.' badge-pill">'.$disponible.'</span>
                                </div>
                             </div>
                        <div class="card-footer">
                        <form action="'.route("Precompra.addcarrito").'" method="post" class="text-right">
                        <input type="hidden" name="_token" value="'.$token.'" >
                        <input type="hidden" name="clave" value="'.openssl_encrypt($producto->id,metodo,key).'" >';
                            if($disponible<=0)
                            {$productos.='<button type="button" class="btn btn-danger btn-sm font-weight-light font-italic" style="font-size:15px;">Agotado</button>';
                            }else{
                           $productos.='<button type="submit" name="btn_accion" value="addCarrito" class="btn btn-info btn-sm font-weight-light font-italic" style="font-size:15px;">Agregar al carrito</button>';
                            }
                        $productos.='</form>
                        </div>
                      </div>
                </div>';
        }
        return($productos);




    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function show(Venta $venta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function edit(Venta $venta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Venta $venta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Venta $venta)
    {
        //
    }
}
