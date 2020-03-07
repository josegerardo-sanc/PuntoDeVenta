<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\abono;
use App\DetalleVenta;
use App\Venta;
use Illuminate\Support\Facades\Auth;

class AbonoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request){

        $id=Auth::user()->id;
        $arreglo_dia_semana=["Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado"];
        $dia_=$arreglo_dia_semana[date('w')];

        $hora=date("Y-m-d g:i a",strtotime(date('H:i:s')));
        $hora=$dia_." ".$hora;

        DB::table('ventas')
            ->where('status_corte', 'no')
            ->where('venta','contado')
            ->update(['status_corte' => 'yes',
                      'fecha_corte' =>$hora,
                      'quien_r_corte'=>$id]);

         DB::table('abonos')
            ->where('status_corte', 'no')
            ->update(['status_corte' => 'yes','fecha_corte' =>$hora,'quien_r_corte'=>$id]);

              return redirect('/home');
    }
    public function historial_Corte_ventas(){
/*
            SELECT SUM(total), fecha FROM ( SELECT b.abono AS total,
            b.fecha_corte AS fecha FROM abonos b WHERE status_corte = "yes"
            UNION ALL
            SELECT v.importe AS total, v.fecha_corte AS fecha FROM ventas v
            WHERE status_corte = "yes" AND venta = "contado" )
            table1 GROUP BY (fecha)
            */
            $cortes=DB::table(DB::raw('(
              SELECT b.abono AS total,b.quien_r_corte AS id_cliente, b.fecha_corte AS fecha
              FROM abonos b WHERE status_corte = "yes"
              UNION ALL
              SELECT v.importe AS total,v.quien_r_corte AS id_cliente, v.fecha_corte AS fecha
              FROM ventas v WHERE status_corte = "yes" AND venta = "contado" ) table1
              INNER JOIN users us on table1.id_cliente=us.id'
                ))
            ->select(DB::raw('fecha, sum(total) as total,name as nombre'))
            ->groupBy('fecha')
            ->get();
            return view('historialVenta.historialcorte',compact('cortes'));
    }

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        //

        $ventas=DB::table('ventas')
            ->leftJoin('clientes', 'ventas.id_cliente', '=', 'clientes.id')
            ->leftJoin('abonos', 'ventas.id', '=', 'abonos.id_ventas')
            ->select('clientes.cliente','ventas.id','ventas.numerofactura','ventas.importe','ventas.venta','ventas.fecha','ventas.hora'
             ,DB::raw('sum(abonos.abono) as abono'))
            ->groupBy('ventas.id')
            ->orderBy('ventas.id','desc')
            ->get();
            //return($ventas);
            return view('historialVenta.index',compact('ventas'));

    }

    public function adeudoClientes(){
        $data=abono::where('id_ventas','=',$_POST['clave'])->sum('abono');
        if($data!="[]"){
            return($data);
        }else{
            $data="";
        }
        //return($data);
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
    public function edit(abono $abono,$id)
    {

        $abonos_detalle=DB::table('ventas')
        ->leftJoin('abonos', 'ventas.id', '=', 'abonos.id_ventas')->where('abonos.id_ventas',$id)
        ->select(DB::raw('sum(abonos.abono) as abono'))
        ->groupBy('ventas.id')
        ->get();
        if(!$abonos_detalle->count()>0)
        {
            $abonos_detalle='[]';
        }
        //return($abonos_detalle);
        //return($id);
        $ventas = DB::table('ventas')
            ->leftJoin('clientes', 'ventas.id_cliente', '=', 'clientes.id')
            ->join('detalle_ventas', 'ventas.id', '=', 'detalle_ventas.id_venta')->where('detalle_ventas.id_venta',$id)
            ->join('productos','detalle_ventas.id_producto','=','productos.id')
            ->select('ventas.*', 'detalle_ventas.*','productos.nombre','clientes.cliente')
            ->get();

        //return($ventas);
//        return view("historialVenta.detalleVenta",compact('ventas'));

return view("historialVenta.detalleVenta")->with('ventas', $ventas)->with('abonos',$abonos_detalle);
    }
    public function abonoCliente()
    {
        //
        if($_POST['action']=="consul_carrito")
        {
            $datas = DB::table('ventas')
            ->leftJoin('clientes', 'ventas.id_cliente', '=', 'clientes.id')
            ->join('detalle_ventas', 'ventas.id', '=', 'detalle_ventas.id_venta')->where('detalle_ventas.id_venta',$_POST['clave'])
            ->join('productos','detalle_ventas.id_producto','=','productos.id')
            ->select('ventas.*', 'detalle_ventas.*','productos.nombre','clientes.cliente')
            ->get();
            return ($datas);

        }

        if($_POST['action']=="insert_abono"){
            if(is_numeric($_POST['cantidad'])){
            if($_POST['cantidad']<=0){
                $arreglo=["respuesta"=>"La cantidad debe ser mayor a cero!!!","valor"=>2];
                return($arreglo);
            }
            $abonos = DB::table('ventas')
                ->leftJoin('abonos', 'ventas.id', '=', 'abonos.id_ventas')->where('ventas.id',$_POST['clave'])
                ->select('ventas.importe',DB::raw('sum(abonos.abono) as abono'))
                ->groupBy('ventas.id')
                ->get();


                if(is_null($abonos[0]->abono)){
                    $cantidad_faltante=$abonos[0]->importe;
                }else{
                    $cantidad_faltante=$abonos[0]->importe==$abonos[0]->abono?'si':$abonos[0]->importe-$abonos[0]->abono;
                    if($cantidad_faltante=="si"){
                        $respuesta="La cuenta esta liquidada";
                        $arreglo=["respuesta"=>$respuesta,"valor"=>1,'abonos'=>$abonos,'ocultar'=>true];
                        return($arreglo);
                    }
                }
                $ocultar_conte=true;
                $respuesta="";

                if($cantidad_faltante==$_POST['cantidad']){
                    $respuesta="1.-Se ha liquidado la cuenta con".$_POST['cantidad']."ps Registro exitoso";

                }
                if($_POST['cantidad']>$cantidad_faltante)
                {
                    $cantidad_new=$_POST['cantidad']-$cantidad_faltante;
                    $_POST['cantidad']=$_POST['cantidad']-$cantidad_new;
                    $respuesta="2.-Se ha liquidado la cuenta con".$_POST['cantidad']."ps has ingresado ".$cantidad_new."ps de mas Registro exitoso";

                }if($_POST['cantidad']<$cantidad_faltante){
                    $respuesta="3.-El abono de ".$_POST['cantidad']."ps se Registro con exitoso";
                    $ocultar_conte=false;
                }

            $abono=new abono;
            $abono->id_ventas=$_POST['clave'];
            $abono->fecha=date('Y-m-d H:i:s');
            $abono->abono=trim($_POST['cantidad']);
            if($abono->save()){
                $abonos = DB::table('ventas')
                ->join('abonos', 'ventas.id', '=', 'abonos.id_ventas')->where('abonos.id_ventas',$_POST['clave'])
                ->select('ventas.importe','ventas.numerofactura', 'abonos.abono','abonos.fecha')
                ->get();
                $arreglo=["respuesta"=>$respuesta,"valor"=>1,'abonos'=>$abonos,'ocultar'=>false];
            }
            else{
                $arreglo=["respuesta"=>"Error: Intente de nuevo","valor"=>2];
               }
            }
            else{
                $arreglo=["respuesta"=>"Solo se permiten ingresar numeros!!!","valor"=>3];
            }
            return($arreglo);
        }
        if($_POST['action']=="consult_abonos"){

            $datas = DB::table('ventas')
            ->leftJoin('abonos', 'ventas.id', '=', 'abonos.id_ventas')->where('ventas.id',$_POST['clave'])
            ->select('ventas.importe','ventas.numerofactura', 'abonos.abono','abonos.fecha')
            ->get();
            $rows=$datas->count();
            if(!$rows>0){
                $datas="";
            }
            return ($datas);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\abono  $abono
     * @return \Illuminate\Http\Response
     */
    public function show(abono $abono)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\abono  $abono
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\abono  $abono
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, abono $abono)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\abono  $abono
     * @return \Illuminate\Http\Response
     */
    public function destroy(abono $abono)
    {
        //
    }
}
