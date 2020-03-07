<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Venta;

use App\Classes\Metodos;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $metodos=new Metodos();


       $numeor_semana=date('W');
       $year = date('Y');
       $month=date('m');
       //echo $year;
       $total=array();
        /*grafica de barra por dias de la smena*/

        /*SELECT fecha, SUM(importe) as monto_dia FROM ventas
        WHERE fecha BETWEEN '2019-12-23' and '2019-12-28'+1
        GROUP BY(DATE_FORMAT(fecha, '%Y-%m-%d'))

        SELECT fecha, SUM(total) as monto_dia FROM (SELECT fecha AS fecha,importe AS total FROM ventas
        WHERE fecha BETWEEN '2019-12-30' and '2020-01-05'+1 AND venta="contado"
        UNION ALL
        SELECT fecha AS fecha,abono AS total FROM abonos
        WHERE fecha BETWEEN '2019-12-30' and '2020-01-05'+1 )
        tabla1 GROUP BY(DATE_FORMAT(fecha, '%Y-%m-%d'))
        */
        $Arr_fechas_semana=array();
        //echo $numeor_semana."\n";
      for($day=0; $day<7; $day++)
       {
        $fecha_this_week=date('Y-m-d', strtotime($year.$numeor_semana.'this week'.$day.'day'));
       // echo $fecha_this_week."\n";
        $Arr_fechas_semana[]=$fecha_this_week;
       }

        $ini_thisweek_=$Arr_fechas_semana[0];
        $fin_thisweek_=$Arr_fechas_semana[count($Arr_fechas_semana)-1];

       // echo $ini_thisweek_;
        $data_graf_barra=DB::table(DB::raw("
                (SELECT DATE_FORMAT(fecha, '%Y-%m-%d') as fecha,importe as total FROM ventas
                WHERE fecha BETWEEN '$ini_thisweek_' and '$fin_thisweek_' AND venta='contado'
                UNION ALL
                SELECT DATE_FORMAT(fecha, '%Y-%m-%d') as fecha,abono AS total FROM abonos
                WHERE fecha BETWEEN '$ini_thisweek_' and '$fin_thisweek_'
                ) as tabla1
            "))
            ->select(DB::raw('fecha, sum(total) as total'))
            ->groupBy('fecha')
            ->get();



        $val_graf_barraX=array();
        $val_graf_barraY=array();

        foreach ($data_graf_barra as $key => $value) {
            # code...
            $val_graf_barraX[]=date('Y/m/d',strtotime($value->fecha));
            $val_graf_barraY[]=$value->total;
        }

        $val_graf_barraX=json_encode($val_graf_barraX);
        $val_graf_barraY=json_encode($val_graf_barraY);

        //return($data_graf_barra);

       ///////////////consulta para grafica 1/////////////
       $data_fecha= DB::table('ventas')
        ->where('venta','=','contado')
        ->where('status_corte','=','yes')
        ->whereYear('fecha',$year)
        ->select(DB::raw('sum(importe) as total,MONTH(fecha) as fecha_mes'))
        ->groupBy('fecha_mes')
        ->get();

        $data_fecha_abono= DB::table('abonos')
        ->whereYear('fecha',$year)
        ->where('status_corte','=','yes')
        ->select(DB::raw('sum(abono) as abono,MONTH(fecha) as fecha_mes'))
        ->groupBy('fecha_mes')
        ->get();

        $arreglo_fecha=
        ['Enero','Febrero','Marzo','Abirl','Mayo',
        'Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

        $mes=[];
        $total_mes=[];

        foreach ($data_fecha as $key => $value) {
            # code...

            $mes[]=$arreglo_fecha[$value->fecha_mes-1];
            $total_mes[]=$value->total;
        }
        //primero verifico que me trae la tabla de los campos fecha,contado

       // $arreglo=["mes"=>$mes,"total"=>$total_mes];
        //return ($arreglo);

        //return($mes);
        foreach ($data_fecha_abono as $key => $value) {
            # code...
            $mes_data=$arreglo_fecha[$value->fecha_mes-1];
            $clave=array_search($mes_data,$mes);
            if($clave!=-1){
                $total_mes[$clave]=$total_mes[$clave]+$value->abono;
            }else{
            $mes[]=$arreglo_fecha[$value->fecha_mes-1];
            $total_mes[]=$value->abono;
            }
        }
        //$arreglo=["mes"=>$mes,"total"=>$total_mes];
        //return ($arreglo);

        $mes=json_encode($mes);
        $total_mes=json_encode($total_mes);


        /*fin de consulta para grafica 1*/


        /*consulta 2 para grafica de pastel*/
        $venta_producto_mes= DB::table('ventas')
        ->join('detalle_ventas','ventas.id','=','detalle_ventas.id_venta')
        ->whereYear('ventas.fecha',$year)
        ->whereMonth('ventas.fecha',$month)
        ->join('productos','productos.id','=','detalle_ventas.id_producto')
        ->select(DB::raw('sum(detalle_ventas.cantidad) as total'),'detalle_ventas.id_producto','productos.nombre')
        ->groupBy('detalle_ventas.id_producto')
        ->get();
        $VentxMesarrName=array();
        $VentxMes_arr=array();

        foreach ($venta_producto_mes as $key => $value) {
            # code...v
            $VentxMesarrName[]=$value->nombre;
            $VentxMes_arr[]=$value->total;
        }
        # code...v
        $VentxMesarrName=json_encode($VentxMesarrName);
        $VentxMes_arr=json_encode($VentxMes_arr);

        //return($venta_producto_mes);
        /*
            SELECT SUM(d.cantidad) as totalXproducto,d.id_producto,p.nombre
            FROM ventas v INNER JOIN detalle_ventas d
            on v.id=d.id_venta AND MONTH(v.fecha) = 10 AND YEAR(v.fecha) = 2019
            inner join productos p
            on p.id=d.id_producto GROUP BY (d.id_producto)
        */

        /*fin de consulta para grafica de pastel*/
        $clientes= DB::table('clientes')
        ->where('status','=','yes')
        ->get();
        $clientes_count=$clientes->count()>0?$clientes->count():0;

        /*busqueda de los 10 ultimos productos y ventas*/
        $productos= DB::table('productos')
        ->where('status','=','yes')
        ->orderBy('id', 'desc')
        ->limit(10)
        ->get();
        if(!$productos->count()>0)
        {
            $productos="";
        }
         $ventas= DB::table('ventas')
        ->join('users','ventas.id_usuario','=','users.id')
        ->select('ventas.*','users.name')
        ->orderBy('ventas.id','desc')
        ->limit(10)
        ->get();
        //return($ventas);
        if(!$ventas->count()>0){
           $ventas="";
        }
        /////////////fin de los 10 ultimos registros de venta y productos/////

        /*venta diaria*/
        $contado= DB::table('ventas')
        ->where('status_corte','=','no')
        ->where('venta','=','contado')
        ->select(DB::raw('sum(importe) as contado'))
        ->get();

        $credito= DB::table('abonos')
        ->where('status_corte','=','no')
        ->select(DB::raw('sum(abono) as credito'))
        ->get();

        $credito=$credito[0]->credito==null?0:$credito[0]->credito;
        $contado=$contado[0]->contado==null?0:$contado[0]->contado;
        $total_venta=$contado+$credito;
        /*fin de venta diaria*/

        $arreglo=["total"=>$total_venta,"contado"=>$contado,"credito"=>$credito,"clientes_count"=>$clientes_count];
        //return($arreglo);
        return view('home',compact('ventas','arreglo','productos','mes','total_mes',
        'VentxMesarrName','VentxMes_arr','val_graf_barraX','val_graf_barraY'));
    }

    public function store(){
        return('hola');
    }
}
