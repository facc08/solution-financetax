<!DOCTYPE html>
<html lang="es">
<!-- Copied from http://radixtouch.in/templates/admin/aegis/source/light/auth-register.html by Cyotek WebCopy 1.7.0.600, Saturday, September 21, 2019, 2:51:57 AM -->

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>SOLUTIONFINANCETAX - Registro</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href=" {{ asset('aegis/source/light/assets/css/app.min.css') }}">

    <link rel="stylesheet" href="{{ asset('aegis/source/light/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('aegis/source/light/assets/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('aegis/source/light/assets/css/custom.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />



    <!-- Template CSS -->
    <link rel='shortcut icon' type='image/x-icon' href="{{ asset('aegis/source/light/assets/img/icono.ico') }}">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

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
                    <div
                        class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
                        <div class="card card-primary">
                            <div class="card-header">

                                <img class="nav_logo_img img-fluid top-right" src="digital/images/solutionlogo1.png">

                            </div>
                            <h4 class="text-center">REGISTRO DE USUARIO</h4>
                            <div class="card-body">
                                <form method="POST" action="{{ route('register') }}" id="form-registro">
                                    @csrf

                                    <div class="form-group row">
                                        <label for="name"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Nombres y Apellidos') }}</label>

                                        <div class="col-md-6">
                                            <input id="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror" name="name"
                                                value="{{ old('name') }}" required autocomplete="name" autofocus>

                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="ciudad"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Ciudad') }}</label>
                                        <div class="col-md-6">
                                            <select class="form-control select2 @error('genero') is-invalid @enderror"
                                                name="ciudad" id="ciudad">
                                                <option selected disabled>Seleccione una Ciudad</option>
                                                @foreach ($ciudades as $e)
                                                    <option value="{{ $e->id }}"> {{ $e->nombre }} </option>
                                                @endforeach
                                            </select>
                                            @error('ciudad')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="genero"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Género') }}</label>
                                        <div class="col-md-6">
                                            <select class="form-control select @error('genero') is-invalid @enderror"
                                                name="genero" id="genero" >
                                                <option selected disabled>Seleccione su G&eacute;nero</option>
                                                <option value="Masculino">Masculino</option>
                                                <option value="Femenino">Femenino</option>
                                            </select>
                                            @error('genero')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="email"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Correo Electrónico') }}</label>

                                        <div class="col-md-6">
                                            <input id="email" type="email"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                value="{{ old('email') }}" required autocomplete="email">

                                                <span role="alert">
                                                    <strong id="mensajeEmail" class="text-danger"></strong>
                                                </span>

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong >{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Contraseña') }}</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                name="password" required autocomplete="new-password" onkeyup='validaContraseñas();'>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password-confirm"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Confirmar Contraseña') }}</label>

                                        <div class="col-md-6">
                                            <input id="password-confirm" type="password" class="form-control"
                                                name="password_confirmation" required autocomplete="new-password" onkeyup='validaContraseñas();'>
                                                <span><i class="fas fa-check text-success" id="validaOk" style="display: none;"></i><i class="fas fa-times text-danger" id="validaNo" style="display: none;"></i>
                                                &nbsp;<span id="msg-password"></span></span>
                                                <br>
                                                <span><i class="fas fa-check text-success" id="validaOkLong" style="display: none;"></i><i class="fas fa-times text-danger" id="validaNoLong" style="display: none;"></i>
                                                &nbsp;<span id="msg-password-long"></span></span>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0" id="divCaptcha" style="display: none;">
                                        <div class="col-md-6 offset-md-4">
                                            <div class="g-recaptcha" data-sitekey="6LcF80UhAAAAADXeUXFHRkTovD_xntzsLECOpf0t"></div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" value="Submit" class="btn btn-primary btn-lg btn-block" id="btn-registrarse-submit" hidden>
                                                <h6>{{ __('Registrarse') }}</h6>
                                            </button>
                                            <span id="mensajeCaptcha" style="display: none;" class="text-center">
                                                <i class="fas fa-exclamation text-danger">&nbsp;Realizar el Captcha para poder registrarse</i>
                                            </span>
                                            <br>
                                            <button class="btn btn-primary btn-lg btn-block" id="btn-registrarse" disabled>
                                                <h6>{{ __('Registrarse') }}</h6>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="mb-4 text-muted text-center">
                                ¿Ya te has registrado? <a href="{{ url('/login') }}">Accede a tu cuenta</a>
                            </div>
                            <div class="mb-4 text-muted text-center">
                                <a href="{{ url('/page') }}">Volver a Página Principal</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- General JS Scripts -->
    <script src="assets/js/app.min.js"></script>

    <!-- JS Libraies -->
    <script src="{{ asset('aegis/source/light/assets/js/app.min.js') }}"></script>
    <script src="{{ asset('aegis/source/light/assets/js/scripts.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Page Specific JS File -->
    <!-- Custom JS File -->
    <script src="{{ asset('aegis/source/light/assets/js/custom.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();
            $("#mensajeEmail").text("");
            $("#email").css("border-color", "#bfbfbf");
            $("#btn-registrarse").click(function(e){
                e.preventDefault();
                $("#mensajeEmail").text("");
                $("#email").css("border-color", "#bfbfbf");
                let email = $("#email").val();
                email = email.replace("@", '"@"');

                $.ajax({url: '/validaEmail/'+email, success: function(result){
                    if(result == "1"){
                        $("#mensajeEmail").text("El campo email ya se encuentra registrado. Por favor usar email distinto.");
                        $("#email").css("border-color", "red");
                    }else{
                        var response = grecaptcha.getResponse();
                        if(response.length == 0){
                            document.getElementById('mensajeCaptcha').style.display = 'block';
                        }else{
                            $("#btn-registrarse-submit").trigger("click");
                        }
                        //$("#btn-registrarse-submit").trigger("click");
                    }
                }});
            });
        });

        //grecaptcha.getResponse(
        //opt_widget_id
        //)

        var validaContraseñas = function() {
            let flagContrasena1 = false;
            let flagContrasena2 = false;

            if ((document.getElementById('password').value == document.getElementById('password-confirm').value)){
                document.getElementById('btn-registrarse').disabled = false;
                document.getElementById('msg-password').style.color = 'green';
                document.getElementById('password').style.color = 'green';
                document.getElementById('password').style.borderColor = 'green';
                document.getElementById('password-confirm').style.color = 'green';
                document.getElementById('password-confirm').style.borderColor = 'green';
                document.getElementById('validaNo').style.display = 'none';
                document.getElementById('validaOk').style.display = 'inline-block';
                document.getElementById('msg-password').textContent = 'Contraseñas coinciden.';
                flagContrasena1 = true;
            } else {
                document.getElementById('btn-registrarse').disabled = true;
                document.getElementById('msg-password').style.color = 'red';
                document.getElementById('password').style.color = 'red';
                document.getElementById('password').style.borderColor = 'red';
                document.getElementById('password-confirm').style.color = 'red';
                document.getElementById('password-confirm').style.borderColor = 'red';
                document.getElementById('validaOk').style.display = 'none';
                document.getElementById('validaNo').style.display = 'inline-block';
                document.getElementById('msg-password').textContent = 'Las contraseñas NO coinciden.';
                flagContrasena1 = false;
            }

            if(document.getElementById('password').value.length >= 8){
                document.getElementById('btn-registrarse').disabled = false;
                document.getElementById('validaNoLong').style.display = 'none';
                document.getElementById('validaOkLong').style.display = 'inline-block';
                document.getElementById('msg-password-long').style.color = 'green';
                document.getElementById('msg-password-long').textContent = 'La contraseña debe tener un mínimo de 8 caracteres.';
                flagContrasena2 = true;
            } else {
                document.getElementById('btn-registrarse').disabled = true;
                document.getElementById('validaOkLong').style.display = 'none';
                document.getElementById('validaNoLong').style.display = 'inline-block';
                document.getElementById('msg-password-long').style.color = 'red';
                document.getElementById('msg-password-long').textContent = 'La contraseña debe tener un mínimo de 8 caracteres.';
                flagContrasena2 = false;
            }

            if(flagContrasena1 && flagContrasena2){
                document.getElementById('divCaptcha').style.display = 'block';
            }else if(!flagContrasena1 || !flagContrasena2){
                document.getElementById('divCaptcha').style.display = 'none';
            }
        }
    </script>
</body>



</html>
