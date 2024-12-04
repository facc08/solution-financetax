@extends('layouts.app')
@section('content')
<div id="app">
    <h1 class="text-center font-weight-bold">Comprobantes Electr&oacute;nicos</h1>
    <h5 class="text-center"><b>Empresa:</b>&nbsp;{{$razonSocial}}&nbsp;&nbsp;&nbsp;<b>RUC:</b>&nbsp;{{$ruc}}</h5>
    <input type="text" id="inputTipoPlan" name="inputTipoPlan" hidden>
    <input type="text" id="inputSubservicio" name="inputSubservicio" hidden>
    <input type="text" id="inputUsuarioEmpresa" name="inputUsuarioEmpresa" hidden>
    @if($flagClave && $flagPeriodo && $flagTipo)
        <comprobantesri-component />
    @else
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="alert alert-danger text-left" role="alert">
                            <h5><i class="fas fa-exclamation-triangle" style="font-size: 18px;"></i>&nbsp;
                                @if(!$flagClave)
                                La empresa no cuenta con clave de acceso ingresada, para poder configurarla
                                <a href="{{route('admin.mis.empresas', $slug )}}" class="alert-link"><u>IR AL SIGUIENTE LINK.</u></a>
                                <br>
                                @endif
                                @if(!$flagPeriodo)
                                La empresa no cuenta con per&iacute;odo de declaraci&oacute;n, para poder configurarlo
                                <a href="{{route('admin.mis.empresas', $slug )}}" class="alert-link"><u>IR AL SIGUIENTE LINK.</u></a>
                                <br>
                                @endif
                                @if(!$flagTipo)
                                El usuario no cuenta con Tipo de Contribuyente configurado, para poder configurarla
                                <a href="{{route('admin.perfil.me')}}" class="alert-link"><u>IR AL SIGUIENTE LINK.</u></a>
                                @endif
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
<script>
    const urlArray = window.location.href.split("/");
    var tipoPlan = urlArray[urlArray.length - 2];
    var subservicio = urlArray[urlArray.length - 3];
    var usuarioEmpresa = urlArray[urlArray.length - 1];

    document.getElementById('inputTipoPlan').value=tipoPlan;
    document.getElementById('inputSubservicio').value=subservicio;
    document.getElementById('inputUsuarioEmpresa').value=usuarioEmpresa;
</script>
@endsection
