<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Nanum+Gothic" rel="stylesheet">


    <title>New HMTL document by NewJect</title>

    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.css')}}">
    @yield('css')


    <link rel="stylesheet" href="{{asset('css/M_encabezado.css')}}">
    <link rel="stylesheet" href="{{asset('css/menu_submenu.css')}}">
    <script src="{{asset('bootstrap/js/all.js')}}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">

</head>

<body style="background-color: #f8fafc;">
    <div class="conte_menu bg-dark text-white" id="header_conte_header">
        <div class="opcion_rigth">
            <a href="#" id="mostrar_menu_items">
                <i class="fas fa-bars"></i>
            </a>
        </div>
        <div class="opcion_rigth right">
               <a href="{{url('/Carrito')}}" id=""><i class="fas fa-shopping-cart"></i>
                <?php
             if(!isset($_SESSION))
            {
                session_start();
            }

            if(isset($_SESSION['carrito'])){
                $cantidad=0;
                foreach ($_SESSION['carrito'] as $key => $value) {
                    # code...
                $cantidad=$cantidad+$value['CANTIDAD'];
                }
              }else{
                  $cantidad=0;
              }
             ?>
             <span style="position:absolute; top:10px;" class="badge badge-primary badge-pill" id="num_products"><?php echo $cantidad;?></span>

            </a>
            <a href="#" style="text-decoration: none;">{{ Auth::user()->name }}</a>
            <img src="{{asset('productos_img/user3-128x128.jpg')}}" alt="" class="img_perfil">
            <a href="#"  id="config_footer"><i class="fas fa-cogs"></i></a>
        </div>
        <ul class="configuraciones_perfil" style="min-width:200px;">
            <li>
                <img src="{{asset('productos_img/user3-128x128.jpg')}}" alt="">
            </li>
            <li>
                <p>{{ Auth::user()->name }} <i class="fas fa-user"></i></p>
            </li>
            <li>
                <p>Editar cuenta <i class="fas fa-edit"></i></p>
            </li>
            <li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn" style="font-size: 13px;">cerrar session</button>
               </form>
            </li>
        </ul>
    </div>

    <nav class="menu_menu">
        <ul class="ul_menu_navegacion">
            <li style="display: flex; justify-content: flex-end; padding: 3px;">
                <button type="button" id="cerrar_men">X</button>
            </li>
            <li>
                <a href="#" id="mas_a" style="display: flex; align-items: center; justify-content:center">
                    <img src="../productos_img/vaquita.jpg" alt="" id="logo">
                    Queseria Bravo
                </a>
            </li>
            <li class="btn_desplegar_menu">
            <a href="{{url('/home')}}" class="">
                    <div class="icon_izq_menu"><i class="fas fa-home"></i></div>
                    Inicio
                </a>
            </li>

            <li class="btn_desplegar_menu">
                <a href="#">
                    <div class="icon_izq_menu"><i class="fab fa-product-hunt"></i></div>
                    <div class="icon_der_menu"><i class="fas fa-angle-down"></i></div>
                    Producto
                </a>
                <ul>
                    <li>
                        <a href="{{url('/producto')}}">
                            <div class="icon_izq_menu"><i class="fas fa-barcode"></i></div>
                            Inventario
                        </a>

                    </li>
                    <li>
                        <a href="{{url('/producto/create')}}">
                            <div class="icon_izq_menu"><i class="fab fa-product-hunt"></i></div>
                            Nuevo producto
                        </a>

                    </li>
                </ul>
            </li>
            <li class="btn_desplegar_menu">
            <a href="{{url('/reabastecer')}}" class="">
                    <div class="icon_izq_menu"><i class="fas fa-history"></i></div>
                     Historial Abastec..
                </a>
            </li>
            <li class="btn_desplegar_menu">
                <a href="#">
                    <div class="icon_izq_menu"><i class="fas fa-cash-register"></i></i></div>
                    <div class="icon_der_menu"><i class="fas fa-angle-down"></i></div>
                    Venta
                </a>
                <ul>
                    <li>
                        <a href="{{url('/venta')}}">
                            <div class="icon_izq_menu"><i class="fas fa-edit"></i></div>
                            Nueva Venta
                        </a>

                    </li>
                    <li>
                    <a href="{{url('/historialVenta')}}">
                            <div class="icon_izq_menu"><i class="fas fa-history"></i></div>
                           Historial de venta
                        </a>

                    </li>
                    <li>
                        <a href="{{url('/historialCorte')}}">
                                <div class="icon_izq_menu"><i class="fas fa-hand-holding-usd"></i></div>
                               Historial de corte
                            </a>

                        </li>
                </ul>
            </li>
            <li class="btn_desplegar_menu">
                <a href="{{url('/cliente')}}" class="">
                        <div class="icon_izq_menu"><i class="fas fa-users"></i></div>
                         Clientes
                </a>
            </li>
            <li class="btn_desplegar_menu">       
                <a class="nav-link" href="{{ route('register') }}">
               <div class="icon_izq_menu"><i class="fas fa-user"></i></div>    
                {{ __('RegistrarUsuario') }}</a>
            </li>
        </ul>
    </nav>

    <div class="container-fluid" id="conteMain">
      @yield('content')
    </div>

    <footer id="pie_pagina" class="bg-dark text-white">
        <strong>Copyright &copy;</strong>
        Todos los derechos estan reservados.
        Version 1.0
    </footer>

   <script src="{{asset('bootstrap/js/jquery-3.3.1.js')}}"></script>
   <script src="{{asset('bootstrap/js/bootstrap.js')}}"></script>

   @yield('script')
   <script src="{{asset('js/menu_modulo_usuario.js')}}"></script>
</body>

</html>
