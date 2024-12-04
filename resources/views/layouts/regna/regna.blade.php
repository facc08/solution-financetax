<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>SolutionFinanceTax</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('aegis/source/light/assets/img/icono.ico') }}" rel="icon">
  <link href="regna/assets/img/apple-touch-icon.png" rel="apple-touch-icon">
 
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Poppins:300,400,500,700" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="regna/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="regna/assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="regna/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="regna/assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="regna/assets/vendor/venobox/venobox.css" rel="stylesheet">
  <link href="regna/assets/vendor/aos/aos.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="regna/assets/css/style.css" rel="stylesheet">
  @laravelPWA
  <!-- =======================================================
  * Template Name: Regna - v2.2.1
  * Template URL: https://bootstrapmade.com/regna-bootstrap-onepage-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/625a5da3b0d10b6f3e6dd594/1g0ofri4l';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
  <!-- ======= Header ======= -->
  <header id="header" class="header-transparent-primary-color">
    <div class="container">
        <a href="{{ url('/page') }}"><img class="img-fluid" style="width: 10rem;" src="images/icons/tax_finance_header.png"></a>
      <nav id="nav-menu-container">
        <ul class="nav-menu">
          <li class="menu-active"><a href="{{ url('/page') }}">Inicio</a></li>
          <li><a href="/page#about">Acerca de Nosotros</a></li>
          <li><a href="/page#services">Servicios</a></li>
          <li><a href="/page#team">Nuestro Equipo</a></li>
          <li><a href="{{ url('/contactenos#contact') }}">Contactenos</a></li>
          {{-- <li class="menu-has-children"><a href="">Drop Down</a>
            <ul>
              <li><a href="#">Drop Down 1</a></li>
              <li class="menu-has-children"><a href="#">Drop Down 2</a>
                <ul>
                  <li><a href="#">Deep Drop Down 1</a></li>
                  <li><a href="#">Deep Drop Down 2</a></li>
                  <li><a href="#">Deep Drop Down 3</a></li>
                  <li><a href="#">Deep Drop Down 4</a></li>
                  <li><a href="#">Deep Drop Down 5</a></li>
                </ul>
              </li>
              <li><a href="#">Drop Down 3</a></li>
              <li><a href="#">Drop Down 4</a></li>
              <li><a href="#">Drop Down 5</a></li>
              <li><a href="#contact">Contact Us</a></li>
            </ul>
          </li> --}}
          <li>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/home') }}">Acceder</a>
                @else
                    <a href="{{ route('login') }}">Ingresar</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Registrar</a>
                    @endif
                @endauth
            @endif
        </li>
        </ul>
      </nav><!-- #nav-menu-container -->
    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero">
    <div class="hero-container" data-aos="zoom-in" data-aos-delay="100">
      <h1>Bienvenido a SolutionFinanceTax</h1>
      <h2>Compartir el mismo objetivo es el primer paso para el Éxito</h2>
      <span id="span-scroll"><div class="mouse"></div></span>
      <span id="text-scroll"><b>Deslizar hacia abajo</b></span>
      {{-- <a href="#about" class="btn-get-started">Conócenos</a> --}}
    </div>
  </section><!-- End Hero Section -->

  <main id="main">
    @yield('content')

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="footer-top">
      <div class="container">

      </div>
    </div>

    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong></strong>. Todos Los Derechos Reservados
      </div>
      <div class="credits">
       
        Creado por <a href="">SmartFastSolution</a>
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

  <!-- Vendor JS Files -->
  <script src="regna/assets/vendor/jquery/jquery.min.js"></script>
  <script src="regna/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="regna/assets/vendor/jquery.easing/jquery.easing.min.js"></script>
  <script src="regna/assets/vendor/php-email-form/validate.js"></script>
  <script src="regna/assets/vendor/counterup/counterup.min.js"></script>
  <script src="regna/assets/vendor/waypoints/jquery.waypoints.min.js"></script>
  <script src="regna/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="regna/assets/vendor/superfish/superfish.min.js"></script>
  <script src="regna/assets/vendor/hoverIntent/hoverIntent.js"></script>
  <script src="regna/assets/vendor/owl.carousel/owl.carousel.min.js"></script>
  <script src="regna/assets/vendor/venobox/venobox.min.js"></script>
  <script src="regna/assets/vendor/aos/aos.js"></script>

  <!-- Template Main JS File -->
  <script src="regna/assets/js/main.js"></script>

</body>

</html>