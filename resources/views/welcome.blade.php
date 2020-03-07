
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('bootstrap/css/carousel.css')}}">

    <script src="{{asset('bootstrap/js/all.js')}}"></script>
    <title>Egresado</title>
    <style>
        .social {
            position: fixed;
            /* Hacemos que la posición en pantalla sea fija para que siempre se muestre en pantalla*/
            left: 0;
            /* Establecemos la barra en la izquierda */
            top: 200px;
            /* Bajamos la barra 200px de arriba a abajo */
            z-index: 12000;
            /* Utilizamos la propiedad z-index para que no se superponga algún otro elemento como sliders, galerías, etc */
        }

        .social ul li a {
            display: inline-block;
            color: #fff;
            background-color: transparent;
            padding: 10px 15px;
            width: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            text-decoration: none;
            -webkit-transition: all 500ms ease;
            -o-transition: all 500ms ease;
            transition: all 500ms ease;
            /* Establecemos una transición a todas las propiedades */
        }

        .social ul {
            list-style: none;
        }

        .social ul li a.face {
            background: #3b5998;
        }

        /* Establecemos los colores de cada red social, aprovechando su class */
        .social ul li a.twitter {
            background: #00abf0;
        }

        .social ul li a.youtube {
            background: #ae181f;
        }

        .social ul li a:hover {
            background-color: lightsteelblue;
            /* Cambiamos el fondo cuando el usuario pase el mouse */
            padding: 10px 30px;
            /* Hacemos mas grande el espacio cuando el usuario pase el mouse */
        }

    </style>

</head>


<body>
    <header>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top" style="background-color:#264071;">
            <a class="navbar-brand" href="http://www.itss.edu.mx/">
                <img src="img/logo.jpg" alt="" style="width:50px; height:50px;"></a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">
                            <i class="fas fa-home"></i>Inicio</a>
                    </li>
                        @if (Route::has('login'))

                        @auth
                        <li class="nav-item">  
                            <a  class="nav-link" href="{{ url('/home') }}">Control Administrativo</a>
                        </li>
                            @else
                            <li class="nav-item">
                                <a  class="nav-link" href="{{ route('login') }}">
                                   <i class="fas fa-user"></i> Login</a>
                             </li>
                        @endauth
                    @endif
                </ul>
            </div>
        </nav>
    </header>

    <main role="main">

        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="first-slide" src="img2.jpeg" alt="First slide">
                    <div class="container">
                        <div class="carousel-caption text-left">
                            <h1>Example headline.</h1>
                            <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                            <p>
                                <a class="btn btn-lg btn-primary" href="#" role="button">Sign up today</a></p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="second-slide" src="img2.jpeg" alt="Second slide">
                    <div class="container">
                        <div class="carousel-caption">
                            <h1>Another example headline.</h1>
                            <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                            <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="third-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Third slide">
                    <div class="container">
                        <div class="carousel-caption text-right">
                            <h1>One more for good measure.</h1>
                            <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                            <p><a class="btn btn-lg btn-primary" href="#" role="button">Browse gallery</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>



        <div class="container marketing">

            <div class="row">
                <div class="col-lg-4">
                    <img class="rounded-circle" src="bolsatrabajo.jpg" alt="Generic placeholder image" width="140" height="140" style="object-fit: cover;">
                    <h2>Bolsa de trabajo</h2>
                    <p>
                        La Red de Bolsa de Trabajo de la Universidad de Guadalajara tiene como objetivo la inserción de los Egresados de CUNorte a nivel técnico y superior al mercado profesional, así como detectar los requerimientos cualitativos de los empleadores, por lo que, a través de este servicio, nuestros egresados pueden registrarse como candidato a obtener una plaza laboral por empresas que aquí mismo registran sus vacantes.

                    </p>
                    <p><a class="btn btn-secondary" href="login_alumno.php" role="button">Ver más &raquo;</a></p>
                </div>
                <div class="col-lg-4">
                    <img class="rounded-circle" src="graduacion.jpg" alt="Generic placeholder image" width="140" height="140" style="object-fit: cover;">
                    <h2>Seguimiento</h2>
                    <p>
                        El Programa de Seguimiento a Egresados del Centro Universitario del Norte, tiene la finalidad de estrechar la vinculación entre la Universidad de Guadalajara y aquellos que se formaron en sus aulas; así como buscar fortalecer la vinculación Universidad-Egresado conservando siempre el contacto ágil y eficaz para mantenerlos con información de interés
                    </p>
                    <p><a class="btn btn-secondary" href="#" role="button">Ver más &raquo;</a></p>
                </div>
                <div class="col-lg-4">
                    <img class="rounded-circle" src="empresa.png" alt="Generic placeholder image" width="140" height="140" style="object-fit: cover;">
                    <h2>EMPLEADORES</h2>
                    <p>
                        Estudio de opinión de empleadores
                        Objetivo:
                        Conocer la opinión de los empleadores de egresados universitarios que permita valorar la pertinencia de los programas educativos que ofrece la institución, así como tomar decisiones para su actualización y acreditación, además de identificar los requerimientos y tendencias del sector productivo en la formación de profesionales competitivos, facilitando la pronta y adecuada inserción laboral de los futuros egresados.
                    </p>
                    <p><a class="btn btn-secondary" href="#" role="button">Registrate &raquo;</a></p>
                </div>
            </div>
       

            <hr class="featurette-divider">

            <div class="row featurette">
                <div class="col-md-7">
                    <h2 class="featurette-heading">La importancia del seguimiento a egresados de <span class="text-muted">educación superior</span></h2>
                    <p class="lead">para los tomadores de decisión, un sistema de seguimiento de egresados les permite contar con información estructurada, continua, confiable y detallada sobre el desempeño académico o laboral de los egresados de la educación superior y con ello diseñar políticas públicas que fortalezcan este nivel educativo. Con la velocidad a la que está cambiando el conocimiento, los datos constituyen una pieza fundamental para dar dirección al rumbo del sistema educativo en un entorno cada vez más dinámico. https://www.milenio.com/opinion/luis-duran/columna-luis-duran/la-importancia-del-seguimiento-a-egresados-de-educacion-superior.</p>
                </div>
                <div class="col-md-5">
                    <img class="featurette-image img-fluid mx-auto" src="img2.jpeg" alt="Generic placeholder image">
                </div>
            </div>

            <hr class="featurette-divider">

            <div class="row featurette">
                <div class="col-md-7 order-md-2">
                    <h2 class="featurette-heading">¿Qué es una bolsa de trabajo y para qué sirve? <span class="text-muted"></span></h2>
                    <p class="lead">Las bolsas de trabajo son el enlace entre las empresas y los candidatos, ya que su servicio consiste en servir como medio para que las empresas den a conocer las ofertas de trabajo que tienen; por lo que estos espacios sirven para reunir tanto a empresas como a candidatos.

                        En la actualidad, las personas buscan trabajo a través de diferentes portales web, por lo que las empresas deben mantener y crear una imagen digital. Una de las bolsas de trabajo en línea más populares de nuestro país es OCCMundial, donde puedes encontrar las vacantes de empresas transnacionales como Bimbo, FEMSA, Televisa, CEMEX, Alsea o empresas nacionales grandes, medianas o pequeñas..</p>
                    <a href="https://www.occ.com.mx/empleos/de-recien-egresados/en-tabasco/" class="btn btn-link">Bolsa de trabajo villhemosa</a>
                </div>
                <div class="col-md-5 order-md-1">
                    <img class="featurette-image img-fluid mx-auto" src="bolsatrabajo.jpg" alt="Generic placeholder image">
                </div>
            </div>

            <hr class="featurette-divider">

            <div class="row featurette">
                <div class="col-md-7">
                    <h2 class="featurette-heading">Empresa <span class="text-muted"></span></h2>
                    <p class="lead">
                        Objetivo:
                        Conocer la opinión de los empleadores de egresados universitarios que permita valorar la pertinencia de los programas educativos que ofrece la institución, así como tomar decisiones para su actualización y acreditación, además de identificar los requerimientos y tendencias del sector productivo en la formación de profesionales competitivos, facilitando la pronta y adecuada inserción laboral de los futuros egresados.
                    </p>
                </div>
                <div class="col-md-5">
                    <img class="featurette-image img-fluid mx-auto" src="empresa.png" alt="Generic placeholder image">
                </div>
            </div>

            <hr class="featurette-divider">

           
            <div class="social">
                <ul>

                    <li><a href="https://www.facebook.com/SomosITSS/?ref=hl" target="_blank" class="face"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="https://www.youtube.com/user/ITSSTABASCO" target="_blank" class="youtube"><i class="fab  fa-youtube-square"></i></a></li>
                    <li><a href="https://twitter.com/TecSierra" target="_blank" class="twitter"><i class="fab  fa-twitter"></i></a></li>
                </ul>
            </div>
        </div>


        <footer class="container">
            <p class="float-right"><a href="#">
                    <i class="fas fa-arrow-up"></i> subir
                </a></p>
            <p>&copy; ITSS Aplicación web © 2019 AUTOR: Maribel de la Cruz Cruz &middot;
                &middot;</p>


        </footer>
    </main>
    <img src="img2.jpeg" alt="" style="width: 100%; height:100vh; object-fit: cover; position: fixed; top: 0px;">
    <div class="social">
        <ul>

            <li><a href="https://www.facebook.com/SomosITSS/?ref=hl" target="_blank" class="face"><i class="fab fa-facebook-f"></i></a></li>
            <li><a href="https://www.youtube.com/user/ITSSTABASCO" target="_blank" class="youtube"><i class="fab  fa-youtube-square"></i></a></li>
            <li><a href="https://twitter.com/TecSierra" target="_blank" class="twitter"><i class="fab  fa-twitter"></i></a></li>
        </ul>
    </div>
    <script src="{{asset('bootstrap/js/jquery-3.3.1.js')}}"></script>
    <script src="{{asset('bootstrap/js/popper.min.js')}}"></script>
    <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('bootstrap/js/holder.min.js')}}"></script>
</body>

</html>
