<?php

namespace App\Http\Controllers;

use App\Reabastecer;
use Illuminate\Http\Request;

use App\Producto;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use DateTime;


class ReabastecerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function printPDF(Request $request)
    {

            $data=request()->all();

            //dd($data);
            $ini=is_null($data['fecha_ini'])?"":$data['fecha_ini'];
            $fin=is_null($data['fecha_fin'])?"":$data['fecha_fin'];
            $code=is_null($data['code'])?"":$data['code'];

            if($ini==""&&$fin!="")
            {$ini=$fin;$fin="";}

            if($fin==""&&$ini!="")
            {$fin=date('Y-m-d');}

            if($ini>$fin){
                $temporal=$fin;
                $fin=$ini;
                $ini=$temporal;
            }

        if(($ini==""&&$fin=="")&& $code=="")
        {
            $reabastecimientos = DB::table('reabastecers')
            ->join('productos', 'productos.id', '=','reabastecers.id_producto')
            ->select('reabastecers.*', 'productos.nombre','productos.codigo')
            ->get();
        }
        if(($ini==""&&$fin=="")&& $code!="")
        {
            $reabastecimientos = DB::table('reabastecers')
            ->join('productos', 'productos.id', '=','reabastecers.id_producto')->where('productos.codigo','=',$code)
            ->select('reabastecers.*', 'productos.nombre','productos.codigo')
            ->get();
        }
        if(($ini!="" && $fin!="")&&$code==""){
            $reabastecimientos = DB::table('reabastecers')
            ->whereBetween('fecha', [$ini,$fin])
            ->join('productos','reabastecers.id_producto', '=', 'productos.id')
            ->select('reabastecers.*', 'productos.nombre','productos.codigo')->get();
        }
        if(($ini!="" && $fin!="")&&$code!=""){
            $reabastecimientos = DB::table('reabastecers')
            ->whereBetween('fecha', [$ini,$fin])
            ->join('productos','reabastecers.id_producto', '=', 'productos.id')->where('productos.codigo', '=',$code)
            ->select('reabastecers.*', 'productos.nombre','productos.codigo')->get();
        }

               // return view('venta.pdf_view',compact('reabastecimientos'));
                $pdf = PDF::loadView('venta.pdf_view',compact('reabastecimientos'));;
                $rand = rand(0, 100);
                $rand = "descarga" . $rand;
                //return $pdf->stream();
                return $pdf->download($rand . '.pdf');


    }


    public function index()
    {
        //SELECT * FROM reabastecers INNER JOIN productos on reabastecers.id_producto=productos.id
        $ini="";
        $code="";
        $fin="";
        $reabastecimientos="";
        if(isset($_GET['action'])){

            $data=request()->all();
            $ini=is_null($data['fecha_ini'])?"":$data['fecha_ini'];
            $fin=is_null($data['fecha_fin'])?"":$data['fecha_fin'];
            $code=is_null($data['code'])?"":$data['code'];

            if($ini==""&&$fin!="")
            {$ini=$fin;$fin="";}

            if($fin==""&&$ini!="")
            {$fin=date('Y-m-d');}

            if($ini>$fin){
                $temporal=$fin;
                $fin=$ini;
                $ini=$temporal;
            }
        }
        if(($ini==""&&$fin=="")&& $code=="")
        {
            $reabastecimientos = DB::table('reabastecers')
            ->join('productos', 'productos.id', '=','reabastecers.id_producto')
            ->select('reabastecers.*', 'productos.nombre','productos.codigo')
            ->get();
        }
        if(($ini==""&&$fin=="")&& $code!="")
        {
            $reabastecimientos = DB::table('reabastecers')
            ->join('productos', 'productos.id', '=','reabastecers.id_producto')->where('productos.codigo','=',$code)
            ->select('reabastecers.*', 'productos.nombre','productos.codigo')
            ->get();
        }
        if(($ini!="" && $fin!="")&&$code==""){
            $reabastecimientos = DB::table('reabastecers')
            ->whereBetween('fecha', [$ini,$fin])
            ->join('productos','reabastecers.id_producto', '=', 'productos.id')
            ->select('reabastecers.*', 'productos.nombre','productos.codigo')->get();
        }
        if(($ini!="" && $fin!="")&&$code!=""){
            $reabastecimientos = DB::table('reabastecers')
            ->whereBetween('fecha', [$ini,$fin])
            ->join('productos','reabastecers.id_producto', '=', 'productos.id')->where('productos.codigo', '=',$code)
            ->select('reabastecers.*', 'productos.nombre','productos.codigo')->get();
        }
        if(isset($_GET['action'])){

            if($_GET['action']=="imprimir")
            {

               // return view('venta.pdf_view',compact('reabastecimientos'));
                $pdf = PDF::loadView('venta.pdf_view',compact('reabastecimientos'));;
                $rand = rand(0, 100);
                $rand = "descarga" . $rand;
                //return $pdf->stream();
                return $pdf->download($rand . '.pdf');

            }
            return($reabastecimientos);
           }
        return view('abastecer.index',compact('reabastecimientos'));
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

        $data=request()->except('_token');
        //dd($data);
        $fecha_actual=date('Y-m-d');
        $feha_post=$data['fecha'];
        if(!is_numeric($data['cantidad'])){

            return redirect('/producto')->with('error', 'La cantidad debe ser numero!!');
        }
        if($feha_post>$fecha_actual){

            return redirect('/producto')->with('error', 'La fecha no puede ser posterior ala de hoy!!');
        }
        $cantidad=trim($data['cantidad']);
        $id=$data['id_producto'];
        Reabastecer::insert($data);
        $data_producto=Producto::findorFail($id);

        $cantidad=$cantidad+$data_producto->cantidad;
        DB::table('productos')->where('id',$id)->update(['cantidad' =>$cantidad]);

        return redirect('/producto')->with('status', 'Reabastecimiento exitoso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reabastecer  $reabastecer
     * @return \Illuminate\Http\Response
     */
    public function show(Reabastecer $reabastecer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reabastecer  $reabastecer
     * @return \Illuminate\Http\Response
     */
    public function edit(Reabastecer $reabastecer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reabastecer  $reabastecer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reabastecer $reabastecer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reabastecer  $reabastecer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reabastecer $reabastecer)
    {
        //
    }
}
