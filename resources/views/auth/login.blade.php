<!DOCTYPE html>
<html lang="en">
<!-- Copied from http://radixtouch.in/templates/admin/aegis/source/light/auth-login.html by Cyotek WebCopy 1.7.0.600, Saturday, September 21, 2019, 2:51:57 AM -->

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>SOLUTIONFINANCETAX- Login</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href=" {{ asset('aegis/source/light/assets/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('aegis/source/light/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('aegis/source/light/assets/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('aegis/source/light/assets/css/custom.css') }}">

    <!-- Template CSS -->
    <link rel='shortcut icon' type='image/x-icon' href="{{ asset('aegis/source/light/assets/img/icono.ico') }}">

</head>
<style type="text/css">
    body {
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url(digital/images/background-logo-blanco.jpg) fixed center center;
    }
</style>
<body>
    <div class="loader"></div>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div  class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <div class="card card-primary">
                           
                            <div class="card-header justify-content-center">
                                <img class="nav_logo_img img-fluid" src="digital/images/solutionlogo1.png">
                            </div>
                            <h4 class="text-center">INICIO DE SESI&Oacute;N</h4>
                            <div class="card-body">
                                @if (Session::has('message'))
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        {{ Session::get('message') }}
                                    </div>
                                @endif
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="email">Correo Electr&oacute;nico</label>
                                        <input id="email" type="email" class="form-control" name="email" tabindex="1"
                                            @error('email') is-invalid @enderror" value="{{ old('email') }}" required
                                            autocomplete="email" autofocus="">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <div class="d-block">
                                            <label for="password" class="control-label">Contraseña</label>
                                            <div class="float-right">
                                                @if (Route::has('password.request'))
                                                    <a class="btn btn-link" href="{{ route('forget.password.get') }}">
                                                        {{ __('¿ Olvidaste tu contraseña ?') }}
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                        <input id="password" type="password" class="form-control" @error('password')
                                            is-invalid @enderror" name="password" tabindex="2" required="">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input class="form-check-input" type="checkbox" name="remember"
                                                id="remember" {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="remember">
                                                {{ __('Recordar sesión') }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                            {{ __('Ingresar') }}
                                        </button>
                                      
                                    </div>
                                </form>
                                <div class="mb-4 text-muted text-center">
                                    ¿ No te has registrado ? <a  href="{{ url('/register') }}">Crear cuenta aqu&iacute;</a>
                                </div>
                                <div class="mb-4 text-muted text-center">
                                      <a  href="{{ url('/page') }}">Volver a p&aacute;gina principal</a>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- General JS Scripts -->
    <script src="{{ asset('aegis/source/light/assets/js/app.min.js') }}"></script>
    <script src="{{ asset('aegis/source/light/assets/js/scripts.js') }}"></script>
    <!-- Page Specific JS File -->
    <!-- Custom JS File -->
    <script src="{{ asset('aegis/source/light/assets/js/custom.js') }}"></script>
</body>

<!-- Copied from http://radixtouch.in/templates/admin/aegis/source/light/auth-login.html by Cyotek WebCopy 1.7.0.600, Saturday, September 21, 2019, 2:51:57 AM -->

</html>
