@extends('layouts.menu')
    @section('css')
        <style>
            .cont_img_carga_gif{
                position: fixed;
                left: 0px;
                top:0px;
                z-index: 909990;
                width: 100%;
                height: 100%;

                display: flex;
                justify-content: center;
                align-items: center;
                background-color: rgba(255,255,255,0.9);
                display: none;


            }
            .conte_img_absoloute{
                position: relative;
                width: auto;
                height: auto;
            }
            .conte_img_absoloute input{
                position: absolute;
                width: 100%;
                height: 100%;
                opacity: 0;
            }

        .productos{
            display: block;
            border: 1px solid #ccc;
            border-radius: 7px;
            padding: 5px;

            object-fit: cover;
            width: 200px;
            height: 200px;
            margin:0px 2px 2px 0px;
        }
        @media (min-width: 750px){
            .productos{
                width: 280px;
                height: 280px;
            }

        }

        </style>
    @endsection
        @section('content')

        <div class="d-flex justify-content-end">
                <a class="btn text-primary" href="{{url('/producto')}}">Lista Productos</a>
                <a class="btn text-muted" href="#">{{isset($producto_edit)?'Actualizar ':'Nuevo '}} Producto</a>
        </div>

        <div class="cont_img_carga_gif">
           <img src="{{asset('storage').'/upload/gif_gif_gifcargando.gif'}}" alt="" class="img_carga_gif">
        </div>
        <input type="hidden" value="{{csrf_token()}}" id="token_producto">
            <div class="row d-flex justify-content-center">
                <div class="col-sm-12 col-md-12">
                        <div class="card">
                                <div class="card-header display-4 font-weight-light">
                                        {{isset($producto_edit)?'Actualizar Producto ':'Registrar Nuevo '}}
                                </div>
                                <div class="card-body">
                                        <form action="" class="form-row" id="form_producto">
                                                    <div class="col-sm-12 col-md-5 col-lg-5 border p-4 mb-3">
                                                            <div style="display:flex; flex-wrap:wrap">
                                                                    <div class="conte_img_absoloute">
                                                                    <input type="file" name="image_producto" class="img_producto">
                                                                    <img id="img_producto_img" class="productos" src="{{isset($producto_edit)?asset('storage').'/'.$producto_edit->image_producto:asset('storage').'/upload/subir_imagen_12323131321323imagen_.png'}}" alt="imagen_new">
                                                                     </div>
                {{--<img class="productos" src="{{asset('storage').'/upload/negocio.jpg'}}" alt="imagen_new">--}}
                                                        @isset($producto_edit)

                                                                <svg class="barcode productos"
                                                                        jsbarcode-format="upc"
                                                                        jsbarcode-value="{{$producto_edit->codigo}}"
                                                                        jsbarcode-textmargin="0"
                                                                        jsbarcode-fontoptions="bold">
                                                                </svg>

                                                        @endisset
                                                        </div>
                                                    </div>
                                                <div class="col-sm-12 col-md-6 p-2">
                                                 <input name="clave" type="hidden" id="input_rut_meth" value="{{isset($producto_edit)?$producto_edit->id:''}}">

                                                          <div class="form-group">
                                                                <label for="">Nombre<strong>(Producto)</strong></label>
                                                                <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                          <span class="input-group-text" id="basic-addon1"><i class="fab fa-product-hunt"></i></span>
                                                                        </div>
                                                                    <input value="{{isset($producto_edit)?$producto_edit->nombre:''}}" name="nombre" type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" required>
                                                                </div>
                                                          </div>
                                                          <div class="form-group">
                                                                <label for="">Precio<strong>(Local)</strong></label>
                                                                <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                          <span class="input-group-text" id="basic-addon1"><i class="fas fa-dollar-sign"></i></span>
                                                                        </div>
                                                                        <input value="{{isset($producto_edit)?$producto_edit->local:''}}" name="local" type="number" min="0" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" required>
                                                                </div>
                                                        </div>
                                                        <div class="form-group">
                                                                <label for="">Precio<strong>(Negocio)</strong></label>
                                                                <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                          <span class="input-group-text" id="basic-addon1"><i class="fas fa-coins"></i></span>
                                                                        </div>
                                                                        <input value="{{isset($producto_edit)?$producto_edit->negocio:''}}" name="negocio" type="number" min="0" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" required>
                                                                </div>
                                                        </div>
                                                        <div class="form-group">
                                                                <label for="">Presentacion<strong>(Kg,Gr,Ml,Lt)</strong></label>
                                                                <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                          <span class="input-group-text" id="basic-addon1"><i class="fas fa-balance-scale"></i></span>
                                                                        </div>
                                                                        <input value="{{isset($producto_edit)?$producto_edit->presentacion:''}}" name="presentacion" type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" required>
                                                                </div>
                                                        </div>
                                                        <div class="form-group">
                                                                <label for="">Cantidad <strong>(Actual)</strong></label>
                                                                <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                          <span class="input-group-text" id="basic-addon1"><i class="fas fa-equals"></i></span>
                                                                        </div>
                                                                        <input {{isset($producto_edit)?'disabled':''}} value="{{isset($producto_edit)?$producto_edit->cantidad:''}}" name="cantidad" type="number" min="0" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" required>
                                                                </div>
                                                        </div>
                                                            <div class="form-group">
                                                                    <label for="">Cantidad Optima<strong>(Stock)</strong></label>
                                                                    <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                              <span class="input-group-text" id="basic-addon1"><i class="fa fa-chart-line"></i></span>
                                                                            </div>
                                                                            <input value="{{isset($producto_edit)?$producto_edit->stock:''}}" name="stock" type="number" min="0" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" required>
                                                                    </div>
                                                            </div>

                                                            <button type="submit" class="btn {{isset($producto_edit)?'btn-danger':'btn-info'}}">
                                                                    {{isset($producto_edit)?'Actualizar Producto':'Registrar Nuevo Producto'}}
                                                            </button>
                                                </div>

                                            </form>
                                </div>
                              </div>
                     </div>
            </div>

            <div style="margin-bottom:120px;"></div>
@endsection



@section('script')
<script src="{{asset('bootstrap/js/bootstrap.js')}}"></script>
<!--regist-->
<script src="{{asset('js/registroProducto.js')}}"></script>
<script src="{{asset('bootstrap/JsBarcode.all.min.js')}}"></script>
@endsection
