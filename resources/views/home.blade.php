{{--@extends('layouts.app')--}}

@extends('layouts.menu')
<style>
.info-box {
    box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
    border-radius: .25rem;
    background: #fff;
    display: -ms-flexbox;
    display: flex;
    margin-bottom: 1rem;
    min-height: 80px;
    padding: .5rem;
    position: relative;
}

.info-box .info-box-content {
    -ms-flex: 1;
    flex: 1;
    padding: 5px 10px;
}
.info-box .info-box-icon {
            border-radius: .25rem;
            -ms-flex-align: center;
            align-items: center;
            display: -ms-flexbox;
            display: flex;
            font-size: 1.875rem;
            -ms-flex-pack: center;
            justify-content: center;
            text-align: center;
            width: 70px;
            color:white;
        }
.info-box .info-box-text, .info-box .progress-description {
    display: block;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.info-box .info-box-number {
    display: block;
    font-weight: 700;
}
.elevation-1 {
    box-shadow: 0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24)!important;
}
/*estilo del producto*/
.products-list .product-img {
    float: left;
}
.products-list {
    list-style: none;
    margin: 0;
    padding: 0;
}
.product-list-in-card>.item {
    border-radius: 0;
    border-bottom: 1px solid rgba(0,0,0,.125);
}

.products-list>.item {
    border-radius: .25rem;
    background: #fff;
    padding: 10px 0;
}

.products-list .product-img img {
    height: 50px;
    width: 50px;
}
.products-list .product-title {
    font-weight: 600;
}
.products-list .product-description {
    color: #6c757d;
    display: block;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.float-right {
    float: right!important;
}
</style>
@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- fix for small devices only -->
        <div class="clearfix hidden-md-up"></div>
        <div class="col-sm-12 col-md-12 row">
            <div class="col-sm-12 col-md-8">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>
                    <div class="info-box-content d-flex justify-content-around flex-wrap">
                        <div>
                        <span class="info-box-text">Total</span>
                        <span class="info-box-number">{{$arreglo['total']}}</span>
                        </div>
                    <div>
                        <span class="info-box-text">Contado</span>
                        <span class="info-box-number">{{$arreglo['contado']}}</span>
                    </div>
                    <div>
                    <span class="info-box-text">Abono</span>
                    <span class="info-box-number">{{$arreglo['credito']}}</span>
                    </div>
                    <div class="mt-3 col-sm-12 d-flex justify-content-around">
                        <!--corte de caja lo manod al controlador de abonoController-->
                    <form action="{{url('historialVenta')}}" method="POST">
                             {{ csrf_field()}}
                            <button type="submit" class="btn btn-danger">Corte Venta</button>
                    </form>
                        <a class="btn btn-success" href="{{url('/venta')}}">Nueva venta</a>
                    </div>
                    </div>
                    <!-- /.info-box-content -->
                </div>
          </div>

            <div class="col">
                <div class="info-box mb-3 d-flex flex-wrap">
                  <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Clientes</span>
                    <span class="info-box-number">{{$arreglo['clientes_count']}}</span>
                  </div>
                  <div class="col-sm-12">
                  <a href="{{url('/cliente')}}" class="btn btn-link">Ver mas</a>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <!-- /.col -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-white">
                    <h3 class="card-title font-weight-light">Grafica Semanal</h3>
                </div>
                <div class="card-body">
                    <div id='barra_div' style="width:90%; overflow-x:auto;"><!-- Plotly chart will be drawn inside this DIV --></div>
                </div>
            </div>
        </div>
      </div>
    <div class="row ">
        <div class="col-md-6 mb-3">
            <div class="card border w-100">
                <div class="card-header bg-white">
                    <h3 class="card-title font-weight-light">Grafica de ventas</h3>
                </div>
                <div class="card-body p-0" style="overflow-x:auto;">
                    <div id="mydiv2"  style="width:95%; min-heigth:300px; max-height:500px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card border w-100">
                <div class="card-header bg-white">
                    <h3 class="card-title font-weight-light">Ultimas ventas</h3>
                </div>
                <div class="card-body p-0" style="overflow-x:auto;">
                    <table class="table table-striped">
                    @if (!empty($ventas))
                            <th>Nº Factura</th><th>Fecha</th><th>importe</th>
                            <th>venta</th><th>Vendedor</th>
                       @foreach ($ventas as $item)
                            <tr>
                            <td><a href="{{url('historialVenta/'.$item->id.'/edit')}}" class="btn-link">{{$item->numerofactura}}</a></td>
                                <td>{{$item->fecha}} {{$item->hora}}</td>
                                <td>{{$item->importe}}</td>
                                <td>{{$item->venta}}</td>
                                <td>{{ucwords($item->name)}}</td>
                            </tr>
                        @endforeach
                    </table>
                    @else

                    <label class="p-3 text-muted">No se ha realizado ninguna venta</label>

                    @endif
                    </table>
                </div>
                <div class="card-footer bg-white border-0 d-flex justify-content-end">
                    <a href="{{url('/historialVenta')}}" class="btn btn-secondary">Ver mas</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-white">
                  <h3 class="card-title font-weight-light">Productos agregados recientemente</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <ul class="products-list product-list-in-card pl-2 pr-2">
                      @if ($productos!="")
                      @foreach ($productos as $producto)
                      <li class="item">
                        <div class="product-img">
                        <img src="{{asset('storage').'/'.$producto->image_producto}}" alt="Product Image" class="img-size-50">
                        </div>
                        <div class="product-info">
                          <a href="" class="product-title">{{$producto->nombre}}
                            <span class="badge badge-warning float-right">${{$producto->local}}</span></a>
                          <span class="product-description">
                            {{$producto->presentacion}}
                          </span>
                        </div>
                      </li>
                      @endforeach
                      @else
                      <li class="item p-4">
                        <div class="mb-3 product-info text-muted">
                          No se encontraron productos registrados
                        </div>
                      </li>
                      @endif
                    <!-- /.item -->
                  </ul>
                </div>
                <!-- /.card-body -->
                <div class="card-footer text-center bg-white">
                <a href="{{url('/producto')}}" class="uppercase">Ver todos los productos</a>
                </div>
                <!-- /.card-footer -->
              </div>
        </div>
        <div class="col-md-6 ">
            <div class="card">
                <div class="card-header bg-white">Grafica de productos  <?php echo date('Y-m');?></div>

                <div class="card-body">

                    <div id='graficapastel' style="width:90%; overflow-x:auto;"><!-- Plotly chart will be drawn inside this DIV --></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div style="margin-bottom:150px;"></div>
@endsection

@section('script')
<script src="{{asset('bootstrap/plotly-latest.min.js')}}"></script>
<script>


function crear(json)
{
    var parsed=JSON.parse(json);
    var arra=[];
    for(var x in parsed)
    {
        arra.push(parsed[x]);
    }

    return arra;
}
var data = [{
  x:crear('<?php echo $val_graf_barraX;?>'),
  y: crear('<?php echo $val_graf_barraY;?>'),
  type: 'bar',
  text:crear('<?php echo $val_graf_barraX;?>'),
  marker: {
    color: 'rgb(142,124,195)'
  }
}];

var layout = {
  title: 'Ingreso Obtenido Por Dia De La Semana',
  font:{
    family: 'Raleway, sans-serif'
  },
  showlegend: false,
  xaxis: {
    tickangle: -45
  },
  yaxis: {
    zeroline: false,
    gridwidth: 2
  },
  bargap :0.05
};

Plotly.newPlot('barra_div', data, layout);

var data = [{
  values:crear('<?php echo $VentxMes_arr?>'),
  labels:crear('<?php echo $VentxMesarrName ?>'),
  textinfo: "label+percent",
  type: 'pie'
}];

var layout = {
  title: 'Producto mas vendido',
  margin: {"b": 0, "l": 0, "r": 0},
  xaxis: {
    //title: 'meses',
    showgrid: false,
    zeroline: false
  },
  yaxis: {
    showline: false
  }
};


Plotly.newPlot('graficapastel',data, layout);


var trace1 = {
  x:crear('<?php echo $mes ?>'),
  y:crear('<?php echo $total_mes ?>'),
  mode: 'markers',
  marker: {
    color: 'rgb(142, 124, 195)',
    size: 12
  },
  type: 'scatter'
};

var data = [trace1];
var layout = {
  title: 'Ingresos por mes',
  xaxis: {
    //title: 'meses',
    showgrid: false,
    zeroline: false
  },
  yaxis: {
    title: 'ventas',
    showline: false
  }
};
Plotly.newPlot('mydiv2', data,layout);
</script>
@endsection


