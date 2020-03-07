@section('css')

<link rel="stylesheet" href="{{asset('bootstrap/DataTable/css/dataTables.bootstrap2.min.css')}}">
<link rel="stylesheet" href="{{asset('bootstrap/DataTable/css/responsive.bootstrap3.min.css')}}">

@endsection


@extends('layouts.menu')

@section('content')

<div class="row">
  <div class="col-sm-12">

    <h1 class="display-4  font-italic">Historial de venta</h1>
    <ul class="d-flex justify-content-around" style="width:250px;">
        <li class="text-danger">Adeudo <i class="fas fa-circle text-danger"></i></li>
        <li class="text-success">Liquidado <i class="fas fa-circle text-success"></i></li>
    </ul>

    <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
        <thead class="table-dark">
            <tr>
                <th>N#</th>
                <th>Factura Nº</th>
                <th>Fecha</th>
                <th>Venta</th>
                <th>Neto</th>
                <th>Vendedor</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody class="font-italic">
        <input type="hidden" class="token_TipVenta" value="{{csrf_token()}}">

        @foreach ($ventas as $key=>$venta)
        <tr data-clave="{{$venta->id}}" class="filas_filas">
            <td>{{$key+1}}</td>
            <td>
                <div class="d-flex flex-column align-items-baseline">
                      <span>{{$venta->numerofactura}}</span>
                      <span class="text-primary">{{$venta->cliente}}</span>
                </div>
            </td>
        <td>{{$venta->fecha}} {{$venta->hora}}</td>
        <td>
            <div class="venta_venta d-flex align-items-center justify-content-center flex-wrap">
                {{$venta->venta}}
            <?php
            $pago_bool="true";//oculto si es true;

            if($venta->venta!="contado"){
            $pago_bool=$venta->importe==$venta->abono?'true':'false';
            $pago=$venta->importe==$venta->abono?'<i class="fas fa-circle text-success"></i>'
            :'<i class="fas fa-circle text-danger"></i>
            <div class="text-danger">'.($venta->importe-$venta->abono).'</div>';
                echo $pago;
             }
            ?>
            </div>
        </td>
        <td>${{$venta->importe}}</td>
            <td>Jose Bravo</td>
                <td>
                <input type="hidden" class="pago_bool" value="{{$pago_bool}}">
                <select  name="" id="" class="pagarHistorial form-control" data-clave="{{$venta->id}}">
                        <option value="0" disabled selected>Opciones</option>
                        <option value="1">Detalle factura</option>
                        <option value="2">Ver PDF</option>
                         @if ($venta->venta=="credito")
                <option value="3">{{$pago_bool=="true"?'Historial pago':'pagar||Historial pago'}}</option>
                         @endif
                </select>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
  </div>
</div>
<div style="margin-bottom: 200px;"></div>


<div class="modal fade" tabindex="-1" role="dialog" id="modal_compra">
    <div class="modal-dialog" role="document">

        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal_factura modal-title">Titulo del modal</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="form-group w-100 alert alert-warning alert-dismissible" role="alert" id="msj_modal"></div>
                <form class="ocultar_pago form-group form-inline" id="formulario_abono" style="display:none">
                        <input  type="number" class="col-sm-8 form-control" id="cantidad_input" placeholder="Ingrese la cantidad a pagar" required>
                        <button type="submit" class="ml-2 btn btn-primary">Pagar</button>
                 </form>
                <table class="table table-responsive font-italic">
                    <tbody class="body_compra" style="overflow-y: auto; overflow-x: hidden;"></tbody>
                </table>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
  </div>
@endsection


@section('script')

<script src="{{asset('bootstrap/DataTable/js/jquery.dataTables1.min.js')}}"></script>
<script src="{{asset('bootstrap/DataTable/js/dataTables.bootstrap2.min.js')}}"></script>
<script src="{{asset('bootstrap/DataTable/js/dataTables.responsive3.min.js')}}"></script>
<script src="{{asset('bootstrap/DataTable/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('js/historialVenta.js')}}"></script>

@endsection
