<?php

namespace App\Http\Controllers;

use App\Cliente;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\Echo_;

class ClienteController extends Controller
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
    public function listar(){

        $datas=Cliente::where('status','=','yes')->get();
        /*$fila='';
       foreach ($datas as $key => $data) {
           # code...
          $fila.='<tr>
          <td>1</td>
          <td>jose gerardo sanchez alvarado</td>
          <td>9321223454</td>
          <td><img src="" alt="imagen"
                  style=" width: 50px; height: 40px; display: block; object-fit: cover;">
          </td>
          <td>
            Cliente
          </td>
          <td>
          <div class="d-flex">
              <a href="#" class="historial btn btn-secondary">
                   <input type="hidden" value="">
                   <i class="fas fa-edit"></i>
              </a>
              <a href="#" class="historial btn btn-secondary">
                    <input type="hidden" value="">
                    <i class="fas fa-trash"></i>
               </a>
          </div>
          </td>
      </tr>';
       }

         return ($fila);*/
        //return response()->json($data->toArray());
        return json_encode(array("data"=>$datas));
    }

    public function index()
    { //
        return view('cliente.index');
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
    public function updateCliente(Request $request){
           $data=request()->all();
           $id_usuario=$data['_clave_cliente'];
           $cliente=Cliente::findorFail($id_usuario);

           //return json_encode($_FILES['img_cliente_p']['name']);

        if($request->hasFile('img_cliente_p')) {
            if($cliente->img_cliente!='upload/12345persona_persona.jpg' ){
             Storage::delete('public/'.$cliente->img_cliente);
           }
           $data['img_cliente_p']=$request->file('img_cliente_p')->store('upload', 'public');
           $cliente->img_cliente=$data['img_cliente_p'];
        }
         $cliente->cliente=ucwords(trim($data['name_cliente']));
         if (isset($_POST["negocio_check"])) {
            $cliente->tipo='yes';
            if($request->hasFile('img_cliente_negocio')) {
                if($cliente->img_negocio!='upload/12345negocio_negocio.jpg' ){
                 Storage::delete('public/'.$cliente->img_negocio);
                 }
                $data['img_cliente_negocio']=$request->file('img_cliente_negocio')->store('upload', 'public');
                $cliente->img_negocio=$data['img_cliente_negocio'];
             }
         }else{
                $cliente->tipo='no';
                $data['name_negocio']="";
                $data['direccion_negocio_cliente']="";
                if($cliente->img_negocio!='upload/12345negocio_negocio.jpg'){
                 Storage::delete('public/'.$cliente->img_negocio);
                }
                $noHayImage='upload/12345negocio_negocio.jpg';
                $cliente->img_negocio=$noHayImage;
            }


         $cliente->telefono=trim($data['telefono_p']);
         $cliente->direccion_p=trim($data['direccion_p']);
         $cliente->negocio=ucwords(trim($data['name_negocio']));
         $cliente->direccion_n=trim($data['direccion_negocio_cliente']);
          $insert_respuesta=false;
         if($cliente->save()){
          $insert_respuesta=true;
         }
         $data=array("respuesta"=>$insert_respuesta,"respuesta_num"=>2);
         return response()->json(array("data"=>$data));
    }

    public function store(Request $request)
    {
        $data=request()->all();
        $cliente=new Cliente;
        if($request->hasFile('img_cliente_p')) {
            $data['img_cliente_p']=$request->file('img_cliente_p')->store('upload', 'public');
            $cliente->img_cliente=$data['img_cliente_p'];
        }else{
            $noHayImage='upload/12345persona_persona.jpg';
            $cliente->img_cliente=$noHayImage;
        }
         $cliente->cliente=ucwords(trim($data['name_cliente']));
         if (isset($_POST["negocio_check"])) {
            $cliente->tipo='yes';
         }
         $cliente->telefono=trim($data['telefono_p']);
         $cliente->direccion_p=trim($data['direccion_p']);
         $cliente->negocio=ucwords(trim($data['name_negocio']));
         $cliente->direccion_n=trim($data['direccion_negocio_cliente']);

         if($request->hasFile('img_cliente_negocio')) {
            $data['img_cliente_negocio']=$request->file('img_cliente_negocio')->store('upload', 'public');
            $cliente->img_negocio=$data['img_cliente_negocio'];
        }else{
            $noHayImage='upload/12345negocio_negocio.jpg';
            $cliente->img_negocio=$noHayImage;
        }
          $insert_respuesta=false;
         if($cliente->save()){
          $insert_respuesta=true;
         }
         $data=array("respuesta"=>$insert_respuesta,"respuesta_num"=>1);
         return response()->json(array("data"=>$data));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show(Cliente $cliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(Cliente $cliente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Cliente::where('id','=',$id)->update(["status"=>"no"]);
    }
}
