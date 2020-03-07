@extends('layouts.menu')

@section('css')
<link rel="stylesheet" href="{{asset('bootstrap/DataTable/css/dataTables.bootstrap2.min.css')}}">
<link rel="stylesheet" href="{{asset('bootstrap/DataTable/css/responsive.bootstrap3.min.css')}}">
@endsection

@section('content')

<div class="d-flex justify-content-end">
        <a class="btn text-muted" >Historial de abastecimieto</a>
</div>
<form action="{{route('customer.printpdf')}}" method="POST">
        @csrf
        <div class="row">
           <div class="col-sm-12 form-group">
                <h4 class="display-4">Historial de abastecimiento </h4>
           </div>
            <div class="col-sm-12 col-md-6 col-lg-5 form-row form-group">
                 <label for="" class="col col-form-label">Desde</label>
                 <input type="date" class="fecha_AJAX col-sm-12 col-lg-10 form-control" id="fecha_ini" name="fecha_ini">
            </div>
            <div class="col-sm-12 col-md-6 col-lg-5 form-row form-group">
                 <label for="" class="col col-form-label">Hasta</label>
                <input type="date" class="fecha_AJAX col-sm-12 col-lg-10  form-control" id="fecha_fin" name="fecha_fin">
            </div>
            <div class="col-sm-12 col-md-6 col-lg-5 form-row form-group">
                    <label for="" class="col col-form-label">Codigo</label>
                   <input min="0" type="number" class="fecha_AJAX col-sm-12 col-lg-10  form-control" id="codigo_product" name="code">
            </div>
            <div class="col-sm-12 col-lg-2 form-group">

            <button type="submit"  class="btn btn-danger"><i class="fas fa-print"></i>Imprimir</button>
            {{--<a href="{{route('customer.printpdf')}}" class="btn btn-primary" >Print PDF</a>--}}
           </div>
        </div>
    </form>

            <table id="example" class="table table-striped  dt-responsive nowrap" style="width:100%">
              <thead class="table-dark text-white text-uppercase text-center">
                    <tr>
                        <th>Codigo</th>
                        <th>Producto</th>
                        <th>Fecha</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                   @foreach($reabastecimientos as $key=>$abastecimiento)
                   <tr class="text-center">
                       <td>
                        {{$abastecimiento->codigo}}
                            {{--<svg class="barcode productos"
                            jsbarcode-format="upc"
                            jsbarcode-value="{{$abastecimiento->codigo}}"
                            jsbarcode-textmargin="0"
                            jsbarcode-fontoptions="bold">
                            </svg>--}}
                       </td>
                       <td>{{$abastecimiento->nombre}}</td>
                       <td>{{$abastecimiento->fecha}}</td>
                       <td>{{$abastecimiento->cantidad}}</td>
                   </tr>
                   @endforeach
                </tbody>
            </table>
            <div style="margin-bottom:100px;"></div>
@endsection

@section('script')

<script src="{{asset('bootstrap/DataTable/js/jquery.dataTables1.min.js')}}"></script>
<script src="{{asset('bootstrap/DataTable/js/dataTables.bootstrap2.min.js')}}"></script>
<script src="{{asset('bootstrap/DataTable/js/dataTables.responsive3.min.js')}}"></script>
<script src="{{asset('bootstrap/DataTable/js/responsive.bootstrap4.min.js')}}"></script>

<script src="{{asset('bootstrap/JsBarcode.all.min.js')}}"></script>
<script src="{{asset('js/consultarProducto.js')}}"></script>
<script src="{{asset('js/historial.js')}}"></script>
@endsection
