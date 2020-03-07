<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css?family=Merriweather&display=swap" rel="stylesheet">
        @section('css')
        <link rel="stylesheet" href="{{asset('bootstrap/carrito.css')}}">
        @endsection
</head>
<body>

    <?php

use App\Classes\Metodos;
$factura=new Metodos();

  if(!isset($_SESSION))
            {
                session_start();
            }

   if(!isset($_SESSION['numFactura']))
   {
    //$factura=new Metodos();
    $numerofactura =$factura->newFactura();
    $_SESSION['numFactura']=$numerofactura;

   }
   else{
   $numerofactura=$_SESSION['numFactura'];
   }

     date_default_timezone_set("America/Mexico_City");
            $date = new DateTime();
            $date=$date->format('d-m-Y H:i:s A');

     //var_dump($_SESSION['carrito']);
     $total=0;
     ?>

@extends('layouts.menu')


 @section('content')
<div class="d-flex justify-content-end font-italic">
    <a class="btn text-primary" href="{{url('/venta')}}">Agregar Producto</a>
    <a class="btn text-muted" >Detalle Venta</a>
</div>

    <input type="hidden" value="{{route('Precompra.TimeUP')}}" id="TimeIsUpPrecompra">
    <form action="{{route('Precompra.addcarrito')}}" method="post" id="formulario_">
      <input type="hidden" id="token_enviar" value="{{csrf_token()}}">
    </form>

   <form action="{{route('Precompra.TipoVenta')}}" method="post"  class="form_TipVenta">
    <input type="hidden" class="token_TipVenta" value="{{csrf_token()}}">
  </form>

    <div class="row">
       <!-- mensaje: compra realizada con exito-->
    {{--@if (session('status'))
        <div class="col-sm-12">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <a href="#">Imprir ticket</a>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
        </div>
     @endif
     --}}
     <!--fin mensaje: compra realizada con exito-->

               <div class="col-sm-12 form-group" style="display:flex; justify-content:space-around; align-items:center; flex-wrap:wrap;">
                    <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <h5 class=" text-muted" id="factura">Numero Factura {{$numerofactura}} </h5>
                            </div>
                            <div class="form-group">
                                 <h5 class="text-muted" id="date">Fecha <?php echo $date;?></h5>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 form-group bg-dark">
                                    @if (isset($_SESSION['carrito']))
                                    @foreach ($_SESSION['carrito'] as $key => $value)
                                            @php
                                            $subTotal=$value['CANTIDAD']*$value['PRECIO'];
                                            $total=$total+$subTotal;
                                            @endphp
                                    @endforeach
                                        <h3 class="text-white display-4 " id="TOTAL_PRECOMPRA">Total {{$total}}</h3>
                                    @else
                                    <h3 class="text-white display-4">Total 0</h3>
                                    @endif
                            <form action="{{url('/venta')}}" method="POST" class="form-group">
                                @csrf
                                <button  type="submit" name="btn_venta" value="cancelar" class="btn btn-sm btn-danger">cancelar Venta</button>
                                <button type="submit" name="btn_venta" value="venta" class="btn btn-sm btn-info">Realizar Venta</button>
                                <div class="col-sm-12 d-flex justify-content-end">
                                    <div class="form-check form-check-inline">
                                       <input class="form-check-input" type="radio" name="pago_" id="inlineRadio1" value="contado" checked>
                                       <label class="text-white form-check-label" for="inlineRadio1">Pago al contado</label>
                                     </div>
                                     <div class="form-check form-check-inline">
                                       <input class="form-check-input" type="radio" name="pago_" id="credito_check" value="credito">
                                       <label class="text-white form-check-label" for="credito_check">Credito</label>
                                     </div>
                              </div>
                            </form>
                       </div>
               </div>
<!-- seperacion de codigo   display:flex; justify-content:space-around; align-items:center-->
<div class="col-sm-12">
        <div class="modal fade" tabindex="-1" role="dialog" id="modal_msj">
                <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title"></h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p id="contenido_msj"></p>
                      <p id="contenido_msj2" class="text-muted"></p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
    @if (isset($_SESSION['carrito']))

    <input id="id_cliente_" type="hidden" value="{{isset($_SESSION['nombre_id_cliente'])?'true':'false'}}">

    <div class="col-sm-12" id="conte_data_cliente" style="{{isset($_SESSION['nombre_id_cliente'])?'':'display:none'}}">
    <h1 class="font-italic lead  border" id=""><strong>Cliente :</strong><i id="name_busqueda_new_cambio">{{isset($_SESSION['nombre_id_cliente'])?$_SESSION["nombre_id_cliente"]:'DEVELOPER :jose gerardo sanchez alvarado'}}</i></h1>
    <form action="{{route('venta.restablecerTipoVenta')}}" method="get">
            <input type="hidden" class="token_TipVenta" value="{{csrf_token()}}">
            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-user-times"></i></button>
            <button type="button" class="btn btn-info btn-sm" id="busqueda_new_cambio"><i class="fas fa-search-plus"></i></button>
    </form>
    </div>
        <ul id="cabecera" class="font-weight-bolder">
            <li>#</li>
            <li>Nombre</li>
            <li>Present</li>
            <li>Precio</li>
            <li>Cantidad</li>
            <li>Total</li>
            <li>Venta</li>
            <li>Opcion</li>
        </ul>
    @foreach ($_SESSION['carrito'] as $key => $value)
    <ul class="contenido font-italic">
        <li class="left_">
        <img src="{{asset('storage').'/'.$value['IMG']}}" alt="">
        </li>
        <li class="rigth_">
            <a href="" class="total_width">{{$value['NOMBRE']}}</a>
        </li>
        <li class="rigth_">
            <a href="" class="uno modificar">Present</a>
            <a href="" class="dos _precio">{{$value['PRESENTACION']}}</a>
        </li>
        <li class="rigth_">
            <a href="" class="uno modificar">Precio</a>
            <a href="" class="dos _precio">{{$value['PRECIO']}}</a>
        </li>
        <li class="rigth_">
            <a href="" class="uno">Cantidad</a>
            <input type="text" value="{{$value['CANTIDAD']}}" class="form-control _input dos input_cantidad">
        </li>
        <li class="rigth_">
            <a href="" class="uno">Total</a>
            <a href="" class="dos _total_">@php
                $subTotal=$value['CANTIDAD']*$value['PRECIO'];
                echo $subTotal;
                $total=$total+$subTotal;
               @endphp</a>
        </li>
        <li class="rigth_">
            <a href="" class="uno">Venta</a>
            <div style=" position:relative; width:auto; height:auto;">
            <select {{isset($_SESSION['nombre_id_cliente'])?'':'disabled'}} name="TipoVenta"  class="form-control _select dos TipoVenta">
              <option value="0" <?php echo $value['VENTA']==0?"selected":"";?>>Local</option>
              <option value="1" <?php echo $value['VENTA']==1?"selected":"";?>>Cliente</option>
            </select>
            <label class="cliente_actual_" for="" style="{{isset($_SESSION['nombre_id_cliente'])?'display:none;':'left:0px; top:0px; z-index: 900000; position: absolute; width: 100%; height:100%;'}}"></label>
            </div>
        </li>
        <li class="rigth_">
            <a href="" class="uno">Opcion</a>
        <form action="" data-id="<?php echo $value['ID']; ?>">
            <div class="btn-group btn-group p-1" role="group" aria-label="">
                <button type="button" class="btn btn-warning text-white btn_delete_producto">
                    <i class="fas fa-trash"></i>
                    {{--<i class='fas fa-sync fa-spin'></i>--}}
                </button>
                {{--
                <button class="btn btn-warning text-white btn_editar" type="button">
                    <i class="fas fa-edit"></i>
                </button>
                --}}
            </div>
          </form>
        </li>
    </ul>


   @endforeach
    @endif
</div>
</div>
</div>

<div style="margin:100px"></div>

<div class="modal fade" id="buscar_cliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <form action="#" method="POST" id="telefono_modal_search">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Buscar cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <div class="input-group mb-3">
                <input type="number" id="num_telefonico" class="form-control" placeholder="Ingrese numero de telefono" aria-describedby="basic-addon2" required>
                <div class="input-group-append">
                 <button type="submit" class="btn btn-info"><i class="fas fa-phone"></i></button>
                </div>
              </div>
              <div class="row" id="conte_elements_m" style="display:none">
                <div class="col-sm-6">
                <img src="" id="img_m" class="img-fluid" style="height='200px'; width:200px;" alt="imagen">
                </div>
                <div class="col-sm-6">
                    <input type="text" id="name_m" class="mb-2 form-control" disabled>
                    <input type="text" id="direccion_m" class="mb-2 form-control" disabled>
                    <input type="text" id="tipo_m" class="form-control" disabled>

                 </div>
              </div>
            </div>
            <div class="modal-footer" id="opcion_cliente_modal">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" id ="btn_aceptar_cliente_m" style="display:none" class="btn btn-success">Aceptar</button>
            </div>
        </div>
        </form>
    </div>
</div>
  @endsection

   @section('script')
   <script src="{{asset('js/venta.js')}}"></script>
   @endsection

</body>
</html>
