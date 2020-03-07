
@section('css')

<link rel="stylesheet" href="{{asset('bootstrap/DataTable/css/dataTables.bootstrap2.min.css')}}">
<link rel="stylesheet" href="{{asset('bootstrap/DataTable/css/responsive.bootstrap3.min.css')}}">

@endsection


@extends('layouts.menu')

@section('content')

<table id="example" class="table  table-bordered dt-responsive nowrap" style="width:100%">
    <thead class="thead-light">
        <tr>
            <th>N#</th>
            <th>Fecha</th>
            <th>importe</th>
            <th>usuario</th>
        </tr>
    </thead>
    <tbody class="font-italic">
    @foreach ($cortes as $key=>$corte)
    <tr>
        <td>{{$key+1}}</td>
        <td>{{$corte->fecha}}</td>
        <td> {{$corte->total}}</td>
        <td> {{$corte->nombre}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<div style="margin-bottom: 200px;"></div>

@endsection


@section('script')

<script src="{{asset('bootstrap/DataTable/js/jquery.dataTables1.min.js')}}"></script>
<script src="{{asset('bootstrap/DataTable/js/dataTables.bootstrap2.min.js')}}"></script>
<script src="{{asset('bootstrap/DataTable/js/dataTables.responsive3.min.js')}}"></script>
<script src="{{asset('bootstrap/DataTable/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('js/historialVenta.js')}}"></script>

@endsection
