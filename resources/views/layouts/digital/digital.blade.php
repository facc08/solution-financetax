<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SOLUTIONFINANCETAX</title>
    @laravelPWA
    <link href="https://fonts.googleapis.com/css?family=Dancing+Script:400,700|Open+Sans:400,600,700,800"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="digital/css/bootstrap.css">
    <link rel="stylesheet" href="digital/css/font-awesome.min.css">
    <link rel="stylesheet" href="digital/css/owl.carousel.min.css">
    <link rel="stylesheet" href="digital/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="digital/css/magnific-popup.css">
    <link rel="stylesheet" href="digital/style.css">
    <link rel="stylesheet" href="digital/responsive.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/v4-shims.css">

    @yield('css')
</head>



<body>
    <div class="wrapper">
        <header class="header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="header-top">
                            <div class="row">
                                <div class="col-md-3 col-sm-12 col-xs-12 ">
                                    <div class="position-absolute top-0 start-0 translate-middle">
                                        <img class="nav_logo_img img-fluid top-left" src="digital/images/logo2.ico">
                                    </div>
                                </div>
                                <div class="col-md-9 col-sm-12 col-xs-12">
                                    <div class="menu">
                                        <ul class="nav navbar-nav">
                                            <li class="active"><a href="{{ url('/page') }}">INICIO</a></li>
                                            <li><a href="{{ url('/nosotros-solution') }}">SOBRE NOSOTROS</a></li>
                                            <li><a href="{{ url('/servicios') }}">SERVICIOS</a></li>
                                            <li><a href="{{ url('/nuestro-equipo') }}">NUESTRO EQUIPO</a></li>
                                            <li><a href="{{ url('/contactenos') }}">CONTACTENOS</a></li>
                                            <li>
                                                @if (Route::has('login'))
                                                    @auth
                                                        <a href="{{ url('/home') }}">ACCEDER</a>
                                                    @else
                                                        <a href="{{ route('login') }}">INGRESAR</a>

                                                        @if (Route::has('register'))
                                                            <a href="{{ route('register') }}">REGISTRAR</a>
                                                        @endif
                                                    @endauth
                                                @endif
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @yield('header')
            </div>
        </header>
        @yield('content')


        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-5 col-xs-6">
                        <div class="text">
                            <p><span><a href="#">Tu Consultoria OnLine </a></span> &copy; 2017 Todos Los Derechos
                                Reservados.</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-3 col-xs-4">
                        <div class="footer-logo">
                            <p><a href="#"> <img class="nav_logo_img img-fluid top-left"
                                        src="digital/images/solutionlogo1.png"></a></p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-2">
                        <div class="icon">
                            <p><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                <a href="#"><i class="fa fa-envelope" aria-hidden="true"></i></a>
                                <a href="#"><i class="fa fa-whatsapp" aria-hidden="true"></i></a>
                                <a href="#"> <i class="fa fa-telegram" aria-hidden="true"></i></a>
                            </p>

                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <script src="digital/js/jquery-3.1.1.min.js"></script>
    <script src="digital/js/bootstrap.min.js"></script>
    <script src="digital/js/owl.carousel.min.js"></script>
    <script src="digital/js/isotope.pkgd.js"></script>
    <script src="digital/js/masonry.js"></script>
    <script src="digital/js/jquery.magnific-popup.min.js"></script>
    <script src="digital/js/active.js"></script>

    @yield('js')

</body>

</html>
