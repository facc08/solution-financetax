@extends('layout')
  
@section('content')
<style type="text/css">
    body {
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url(digital/images/background-logo-blanco.jpg) fixed center center;
    }
</style>
<main class="login-form">
  <div class="cotainer mt-5">
      <div class="row">
          <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
              <div class="card card-primary">
                <div class="card-header">
                    <img class="nav_logo_img img-fluid top-right" src="digital/images/solutionlogo1.png">
                </div>
                <br>
                    <h4 class="text-center">REINICIAR CONTRASEÑA</h4>
                  <div class="card-body">
  
                    @if (Session::has('message'))
                         <div class="alert alert-success" role="alert">
                            {{ Session::get('message') }}
                        </div>
                    @endif
  
                      <form action="{{ route('send.password') }}" method="POST">
                          @csrf
                          <div class="form-group row">
                              <label for="email_address" class="col-md-4 col-form-label text-md-right">Correo Electr&oacute;nico</label>
                              <div class="col-md-6">
                                  <input type="text" id="email_address" class="form-control" name="email" required autofocus>
                                  @if ($errors->has('email'))
                                      <span class="text-danger">{{ $errors->first('email') }}</span>
                                  @endif
                              </div>
                          </div>
                          <div class="col-md-6 offset-md-4">
                              <button type="submit" class="btn btn-primary btn-lg btn-block">
                                  Enviar URL de recuperaci&oacute;n
                              </button>
                          </div>
                      </form>
                        
                  </div>
              </div>
          </div>
      </div>
  </div>
</main>
@endsection