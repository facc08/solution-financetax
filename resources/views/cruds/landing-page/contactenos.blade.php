@extends('layouts.regna.regna')

@section('content')

<section id="contact">
    <div class="container">
      <div class="section-header">
        <h3 class="section-title">CONTACTANOS</h3>
      </div>
    </div>

    <!-- Uncomment below if you wan to use dynamic maps -->
    <div class="container mt-5">
      <div class="row justify-content-center">

        <div class="col-lg-3 col-md-4">

          <div class="info">
            <div>
              <i class="fa fa-map-marker"></i>
              <p>Avenida Siempre Viva<br>Guayaquil, Entre la que mira y sale</p>
            </div>

            <div>
              <i class="fa fa-envelope"></i>
              <p>SolutionFinanceTax@example.com</p>
            </div>

            <div>
              <i class="fa fa-phone"></i>
              <p>+593 XXX XXX XXX</p>
            </div>
          </div>

          <div class="social-links">
            <a href="#" class="twitter"><i class="fa fa-twitter"></i></a>
            <a href="#" class="facebook"><i class="fa fa-facebook"></i></a>
            <a href="#" class="instagram"><i class="fa fa-instagram"></i></a>
            <a href="#" class="google-plus"><i class="fa fa-google-plus"></i></a>
            <a href="#" class="linkedin"><i class="fa fa-linkedin"></i></a>
          </div>

        </div>

        <div class="col-lg-5 col-md-8">
          <div class="form">
            <form action="forms/contact.php" method="post" role="form" class="php-email-form">
              <div class="form-group">
                <input type="text" name="name" class="form-control" id="name" placeholder="Nombre y Apellido" data-rule="minlen:4" data-msg="Please enter at least 4 chars" />
                <div class="validate"></div>
              </div>
              <div class="form-group">
                <input type="email" class="form-control" name="email" id="email" placeholder="Su correo" data-rule="email" data-msg="Please enter a valid email" />
                <div class="validate"></div>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="subject" id="subject" placeholder="Sugerencia o Pregunta" data-rule="minlen:4" data-msg="Please enter at least 8 chars of subject" />
                <div class="validate"></div>
              </div>
              <div class="form-group">
                <textarea class="form-control" name="message" rows="5" data-rule="required" data-msg="Detalle del Mensaje" placeholder="Message"></textarea>
                <div class="validate"></div>
              </div>
              <div class="mb-3">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">Your message has been sent. Thank you!</div>
              </div>
              <div class="text-center"><button type="submit">Enviar Mensaje</button></div>
            </form>
          </div>
        </div>

      </div>

    </div>
  </section><!-- End Contact Section -->


@endsection