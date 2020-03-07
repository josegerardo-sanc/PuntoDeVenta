<?php

namespace App\Http\Controllers;

use App\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse\RedirectResponse\redirect;

class ProductoController extends Controller
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
    public function index()
    {

        $productos=Producto::where('status','=','yes')->get();
        return view('producto.index',compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('producto.registro');
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

        $producto= new Producto;

        if($request->hasFile('image_producto')) {

            $data['image_producto'] =$request->file('image_producto')->store('upload', 'public');
            $producto->image_producto=$data['image_producto'];
         }else{
             $noHayImage='upload/12345678producto_new.png';
             $producto->image_producto=$noHayImage;
            }
            //code
            $fechaEntera=date('Y-m-d H:i:s');
            $anio = date("Y",strtotime($fechaEntera));
            $mes = date("m",strtotime($fechaEntera));
            $dia = date("d", strtotime($fechaEntera));
            $hora = date('H',strtotime($fechaEntera));
            $minuto=date('i',strtotime($fechaEntera));
            $segundo=date('s',strtotime($fechaEntera));
            $anio=substr($anio,3);
            $code=$hora.$anio.$mes.$minuto.$dia.$segundo;
            //fin code
             $producto->codigo=$code;

        $producto->nombre=trim(ucwords($data['nombre']));
        $producto->local=trim($data['local']);
        $producto->negocio=trim($data['negocio']);
        $producto->presentacion=trim(ucwords($data['presentacion']));
        $producto->cantidad=trim($data['cantidad']);
        $producto->stock=trim($data['stock']);
                $bool_exito=0;
                if($producto->save()){
                    $bool_exito=1;
                }
        return json_encode(array("data"=>[],"respuesta"=>$bool_exito));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $producto_edit=Producto::findorFail($id);
        return view("producto.registro",compact('producto_edit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update_post(Request $request)
    {
        $data=request()->all();
        $clave=$data['clave'];

        $producto=Producto::findorFail($clave);

        if($request->hasFile('image_producto')) {
            if($producto->image_producto!='upload/12345678producto_new.png' ){
                 Storage::delete('public/'.$producto->image_producto);
               }
            $data['image_producto'] =$request->file('image_producto')->store('upload', 'public');
            $producto->image_producto=$data['image_producto'];
         }
        $producto->nombre=trim(ucwords($data['nombre']));
        $producto->local=trim($data['local']);
        $producto->negocio=trim($data['negocio']);
        $producto->presentacion=trim(ucwords($data['presentacion']));
        $producto->stock=trim($data['stock']);
        $bool_exito=0;
            if($producto->save()){
                    $bool_exito=2;
             }
        return json_encode(array("data"=>[],"respuesta"=>$bool_exito));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //dd($id);

       $msj=Producto::where('id', $id)->update(['status'=>'no']);
       return redirect('/producto');
    }
}
