
@section('css')
<style>
  .letra{
      font-size:10px;
  }
  .tamano{
      display:block;
      height: 100px;
      object-fit: cover;
  }
  @media (min-width: 600px) {
   .tamano{
      height: 250px;
   }
   .letra{
      font-size:15px;
  }
  }

  </style>
@endsection

<?php
   if(!isset($_SESSION))
    {
    session_start();
    }

use App\Classes\Metodos;
$metodos=new Metodos;

?>
    @extends('layouts.menu')
    @section('content')
<div class="d-flex justify-content-end">
    <a class="btn text-muted" >Productos</a>
</div>

<div class="row">
  @if (session('status'))
        <div class="modal fade" tabindex="-1" role="dialog" id="_msj_">
          <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>{{ session('status') }}.</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
@endif
  @if ($productos=="[]")
  <div class="col-sm-12 form-group">
      <h4 class=" display-4 text-muted">No se han registrado productos</h4>
      <a href="{{url('/producto/create')}}" class=" btn btn-warning text-white">
        <i class="fab fa-product-hunt"></i>Nuevo producto</a>
   </div>
@else
    <div class="form-group col-sm-12 d-flex align-items-center flex-wrap">
    <input type="hidden" value="{{csrf_token()}}" id="token_token_">
        <label for="search_product_index" class="col-form-label mr-2">Nombre del prodcuto </label>
        <input id="search_product_index" type="search" class="form-control" style="max-width:300px;" placeholder="Busqueda por nombre">
    </div>
      <div class="conte_productos_ row col-sm-12">
       @foreach ($productos as $producto)
                <div class="w-50 col-sm-6 col-md-4 col-lg-3">
                    <div class="card m-0 p-0">
                    <img src="{{asset('storage').'/'.$producto->image_producto}}" class="card-img-top tamano"   alt="...">
                        <div class="card-body">
                               <h2 class="lead small text-muted d-inline-block"><b>{{$producto->nombre}}</b></h2>
                               <div class="lead small text-muted  d-flex justify-content-between align-items-center">
                                Presentac
                              <span class="badge badge-warning badge-pill">{{$producto->presentacion}}</span>
                              </div>
                               <div class="lead small text-muted  d-flex justify-content-between align-items-center">
                                  Precio
                                <span class="badge badge-primary badge-pill">{{$producto->local}}</span>
                                </div>
                                <div class="lead small text-muted  d-flex justify-content-between align-items-center">
                                  Disponibles
                                  <?php
                                      $disponible="";
                                      $color='badge-primary';
                                      $disponible=$producto->cantidad - $producto->pedido;
                                      if($disponible<=0){
                                        $disponible=0;
                                        $color='badge-ligth';

                                      }
                                  ?>
                                  <span class="badge {{$color}} badge-pill">{{$disponible}}</span>
                                </div>
                        </div>
                        <div class="card-footer">
                            <form action="{{route('Precompra.addcarrito')}}" method="post" class="text-right">
                                @csrf
                             <input type="hidden" name="clave" value="<?php echo openssl_encrypt($producto->id,metodo,key); ?>" >
                             @if($disponible<=0)
                             <button type="button" class="btn btn-danger btn-sm font-weight-light font-italic" style="font-size:15px;">Agotado</button>
                             @else
                             <button type="submit" name="btn_accion" value="addCarrito" class="btn btn-info btn-sm font-weight-light font-italic" style="font-size:15px;">Agregar al carrito</button>
                             @endif
                        </form>
                        </div>
                      </div>
                </div>
       @endforeach
      </div>
@endif
</div>

<div style="margin-bottom:150px;"></div>
    @endsection


@section('script')
<script src="{{asset('js/venta.js')}}"></script>

@endsection
