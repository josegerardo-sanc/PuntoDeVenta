@extends('layouts.menu')



@section('content')
<div class="d-flex justify-content-end">
<a class="btn btn-link" href="{{url('/home')}}">Inicio</a>
<a class="btn btn-link" href="{{url('historialVenta')}}">Historial de venta</a>
    <a class="btn text-muted" href="#">Detalle venta</a>
</div>
<div class="row justify-content-center">
    <div class="col-sm-10">
        <div class="card text-center">
            <div class="card-header text-info">
                <h5 class="card-title">Detalle de la venta</h5>
            </div>
            <div class="card-body">
              <div class="form-row text-primary">
                  <div class="col-sm-12">
                      <label for="" class="col-form-label">
                          @if ($ventas[0]->cliente!="")
                            {{$ventas[0]->cliente}}
                          @endif
                      </label>
                  </div>
                  <div class="col-sm-4">
                      <label class="col-form-label" for="">Nº factura
                        <span class="badge badge-secondary">
                          {{$ventas[0]->numerofactura}}</span></label>
                  </div>
                  <div class="col-sm-2">
                    <label class="col-form-label" for="">Importe
                    <span class="badge badge-secondary">{{$ventas[0]->importe}}</span></label>
                  </div>
                  @if ($ventas[0]->venta!='contado')
                  <label class="col-form-label" for="">Adeuda
                    @if ($abonos!="[]")
                     <?php
                        //echo $abonos[0]->abono;
                        $adeuda=$ventas[0]->importe==$abonos[0]->abono?'NO':$ventas[0]->importe-$abonos[0]->abono;
                     ?>
                     <span class="badge badge-warning text-white">{{$adeuda}}</span>
                    @else
                     <span class="badge badge-warning text-white">{{$ventas[0]->importe}}</span>
                    @endif
                   </label>
                  @endif

                <div class="col-sm-4">
                 <label for="" class="col-form-label">
                  Venta <span class="badge {{$ventas[0]->venta!='contado'?'badge-danger':'badge-success'}}">{{$ventas[0]->venta}}</span>
                </label>
                </div>
              </div>
              <table class="table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Tipo venta</th>
                        <th>SubTotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $total=0;
                    ?>
                    @foreach ($ventas as $item)
                    <tr>
                        <td>{{$item->nombre}}</td>
                        <td>{{$item->cantidad}}</td>
                        <td>{{$item->precio}}</td>
                        <td>{{$item->tipo_venta}}</td>
                        <?php
                            $subtotal=$item->cantidad*$item->precio;
                            $total=$total+$subtotal;
                        ?>
                        <td>{{$subtotal}}</td>
                    </tr>
                    @endforeach
                    <tr>
                    <td  align="right" colspan="4"><strong>Total</strong></td>
                    <td>{{$total}}</td>
                    </tr>
                </tbody>
                </table>

            </div>
            <div class="card-footer text-muted">
                Fecha {{$ventas[0]->fecha}}
            </div>
          </div>
    </div>
</div>



@endsection
