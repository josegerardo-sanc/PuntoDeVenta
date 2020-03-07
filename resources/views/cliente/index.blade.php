
@section('css')
<link rel="stylesheet" href="{{asset('bootstrap/DataTable/css/dataTables.bootstrap2.min.css')}}">
<link rel="stylesheet" href="{{asset('bootstrap/DataTable/css/responsive.bootstrap3.min.css')}}">
        <style>
        .conte_ {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin:30px 0px 60px 0px;
        position: relative;
        }

        .name_cliente_{
            width:70%;
        }


        .conte_img img,
        .file_usuario {
        position: absolute;
        top:-40px;
        left:5px;
        border: 1px solid #dADADA;
        border-radius: 50%;
        height:130px;
        width:30%;
        padding: 3px;
        background-color: white;
        }
        .conte_img img{
            display: block;
            object-fit: cover;
        }
        .file_usuario {
        background-color: white;
        color: white;
        opacity: 0;
        z-index: 1000;
        }
        </style>
    @endsection

    @extends('layouts.menu')

    @section('content')
    <div class="d-flex justify-content-end font-italic">
        <a class="btn text-muted" >Clientes</a>
    </div>
<ul class="form-group" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap">
            <!-- btn Invocar al modal -->
            <li><h1 class="display-4 text-primary">Lista de Clientes</h1></li>
            <li>
                    <button type="button" class="btn btn-primary" id="new_cliente_">
                            Nuevo cliente
                    </button>
            </li>
        </ul>

<div class="row">
   <div class="col-sm-12">
    <table id="example" class="table table-striped  dt-responsive nowrap" style="width:100%">
        <thead>
              <tr>
                  <th></th>
                  <th>Nombre</th>
                  <th>telefono</th>
                  <th>foto</th>
                  <th>tipo</th>
                  <th>Opciones</th>
              </tr>
          </thead>
          <tbody id="body_table_cliente">
          </tbody>
      </table>
   </div>
</div>
<div class="modal fade" id="Cliente_negocio" tabindex="-1" role="dialog" aria-labelledby="Cliente_negocio" aria-hidden="true">
    <form action="" id="formulario_cliente">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <input type="hidden" value="{{csrf_token()}}" id="token_cliente">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title display-4 text-info" id="registro_cliente_title">Registro cliente</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                             <input type="hidden" value="clave_cliente" id="_clave_cliente" name="_clave_cliente">
                            <div class="conte_">
                                <div class="conte_img">
                                    <img id="img_cliente_img" src="{{asset('storage').'/upload/12345persona_persona.jpg'}}" alt="Add Image" class="img">
                                    <input type="file" class="file_usuario" name="img_cliente_p" id="img_cliente_p name_cliente_" data-img="false">
                                </div>
                                <input type="text" id="name_cliente" name="name_cliente" class="form-control name_cliente_" placeholder="Ingrese su nombre completo" required>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="fas fa-phone"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="telefono_p" name="telefono_p" placeholder="Ingresu su numero telefonico" aria-label="Username" aria-describedby="basic-addon1" required>
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="fas fa-home"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="direccion_p" name="direccion_p" placeholder="Ingrese su direccion" aria-label="Username" aria-describedby="basic-addon1" required>
                            </div>
                            <!--  radios -->
                            <div class="form-group">
                                <label for="cliente" class="">Cliente
                                    <input type="checkbox" id="cliente" checked disabled>
                                </label>
                                <label for="negocio" class="">Negocio
                                    <input type="checkbox" name="negocio_check" id="negocio">
                                </label>
                            </div>
                            <!--fin radios -->
                            <div class="conte_negocio" style="display: none;">
                                    <div class="conte_">
                                        <div class="conte_img">
                                            <img id="img_negocio_img" src="{{asset('storage').'/upload/12345negocio_negocio.jpg'}}" alt="Add Image" class="img">
                                            <input type="file" class="file_usuario" name="img_cliente_negocio" id="img_cliente_negocio" data-img="false">
                                        </div>
                                        <input  type="text" id="name_negocio" name="name_negocio" class="form-control name_cliente_" placeholder="Nombre  del Negocio">
                                    </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="fas fa-phone"></i>
                                        </span>
                                    </div>
                                    <input  type="text" id="direccion_negocio" name="direccion_negocio_cliente" class="form-control" placeholder="Ingresu Su Direccion" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btn_close__" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" id="btn_cliente__" class="btn btn-sm btn-primary">Agregar</button>
                        </div>
                    </div>
            </div>
    </form>
</div>
<div style="margin-top: 100px;"></div>

  <!-modal-->

    @endsection


@section('script')
<script src="{{asset('bootstrap/DataTable/js/jquery.dataTables1.min.js')}}"></script>
<script src="{{asset('bootstrap/DataTable/js/dataTables.bootstrap2.min.js')}}"></script>
<script src="{{asset('bootstrap/DataTable/js/dataTables.responsive3.min.js')}}"></script>
<script src="{{asset('bootstrap/DataTable/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('js/consultarProducto.js')}}"></script>
<script src="{{asset('js/cliente.js')}}"></script>
@endsection
