@extends('layouts.menu')

@section('css')
<link rel="stylesheet" href="{{asset('bootstrap/DataTable/css/dataTables.bootstrap2.min.css')}}">
<link rel="stylesheet" href="{{asset('bootstrap/DataTable/css/responsive.bootstrap3.min.css')}}">
@endsection


@section('content')

<div class="d-flex justify-content-end">
        <a class="btn text-muted" href="#">Inventario</a>
</div>

    <div class="row">
        <div class="col-sm-12">

            <ul class="form-group" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap">
                <!-- btn Invocar al modal -->
                <li><h1 class="display-4 text-primary font-italic">Lista de productos</h1></li>
                <li>
                    <a href="{{url('/producto/create')}}" class="btn btn-info text-white">Agregar Producto</a>
                </li>
            </ul>
            @if (session('status'))
            <div class="alert alert-warning alert-dismissible fade show mt-2" role="alert" id="">
                <strong> {{session('status')}}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert" id="">
                <strong> {{session('error')}}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
           @endif
            <table id="example" class="table table-striped  dt-responsive nowrap" style="width:100%">
              <thead class="table-dark">
                    <tr>
                        <td>N#</td>
                        <th>Codigo</th>
                        <th>Producto</th>
                        <th>Imagen</th>
                        <th>Almacen</th>
                        <th>Present.</th>
                        <th>Status</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                @if(!empty($productos))
                @foreach($productos as $key=>$producto)
                    <tr style="100px" class="font-italic">
                        <td>{{$key+1}}</td>
                         <td style="width:100px;">
                             <div class="d-flex justify-content-center align-items-baseline">
                                    <svg style="width:150px; height:80px;" class="barcode border"
                                    jsbarcode-format="upc"
                                    jsbarcode-value="{{$producto->codigo}}"
                                    jsbarcode-textmargin="0"
                                    jsbarcode-fontoptions="bold">
                                    </svg>
                             </div>
                        </td>
                        <td>{{$producto->nombre}}</td>
                        <td><img src="{{asset('storage').'/'.$producto->image_producto}}" alt=""
                                style="border-radius: 7px; padding: 2px solid #ccc;width: 100px; height: 70px; display: block; object-fit: cover;"></td>
                        <td><strong>{{$producto->cantidad}}</strong>Pz</td>
                        <td>{{$producto->presentacion}}</td>
                        <td>
                        <?php
                          $color="";
                          $width_prog="";
                          $text_pr="";
                          $stock=round(($producto->cantidad/$producto->stock)*100);

                          if($stock>=50)
                          {
                            $width_prog=$stock.'%';
                            $text_pr="Suficiente";
                            $color="bg-success";
                          }if($stock<50)
                          {
                             $width_prog=$stock.'%';
                             $text_pr="InSuficiente";
                             $color="bg-danger";
                            }
                          if($stock==0){
                             $width_prog='100%';
                            $text_pr="Agotado";
                            $color="bg-danger";
                          }
                            //echo $width_prog;
                        ?>
                          <div class="" style="">
                                <div class="progress form-group" id="">
                                <div id="percent" class="progress-bar <?php echo $color;?>" role="progressbar" style="width:<?php echo $width_prog;?>" aria-valuemin="0"
                                aria-valuemax="100"><?php echo $text_pr; ?></div>
                           </div>
                          </div>
                       </td>
                        <td>
                        <div class="d-flex">
                            <a href="{{url('/producto/'.$producto->id.'/edit')}}"
                                class="btn btn-warning text-white editar">
                                <i class="fas fa-edit"></i></a>
                            <a href="#" class="eliminar btn btn-danger">
                                 <input type="hidden" value="{{url('/producto/'.$producto->id)}}">
                                <i class="fas fa-trash"></i>
                            </a>
                            <a href="#" class="historial btn btn-secondary">
                                 <input type="hidden" value="{{$producto->id}}">
                                 <i class="fas fa-plus-square"></i>
                            </a>
                        </div>
                        </td>
                    </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>



    <div class="modal fade" id="eliminar_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
    aria-hidden="true">
    <div class="modal-dialog" role="document">

    <form action="" method="post" id="formulario_eliminar">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Eliminar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                Continuar con la eliminacion del <strong>Producto</strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-danger">Eliminar</button>
            </div>
        </div>
        </form>
    </div>
    </div>

   <!--modal de abastecimeinto producto-->
<div class="modal fade" id="reabastecer_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
    aria-hidden="true">
    <div class="modal-dialog" role="document">

    <form action="{{url('/reabastecer')}}" method="POST" id="form_reabastecer">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Reabastecer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            {{csrf_field()}}
            <div class="form-group">
               <input type="hidden" id="clave_producto" name="id_producto">
                <label for="" class="col-form-label">Cantidad</label>
                <input type="number" class="form-control" placeholder="" name="cantidad" required>
            </div>
            <div class="form-group">
                <label for="" class="col-form-label">Fecha</label>
                <input type="date" class="form-control" name="fecha" required>
            </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Aceptar</button>
            </div>
        </div>
        </form>
    </div>
</div>
<div style="margin-bottom:100px;"></div>
@endsection

@section('script')
<script src="{{asset('bootstrap/DataTable/js/jquery.dataTables1.min.js')}}"></script>
<script src="{{asset('bootstrap/DataTable/js/dataTables.bootstrap2.min.js')}}"></script>
<script src="{{asset('bootstrap/DataTable/js/dataTables.responsive3.min.js')}}"></script>
<script src="{{asset('bootstrap/DataTable/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('bootstrap/JsBarcode.all.min.js')}}"></script>
<script src="{{asset('js/consultarProducto.js')}}"></script>
@endsection
