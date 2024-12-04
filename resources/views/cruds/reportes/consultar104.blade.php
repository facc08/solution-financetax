@extends('layouts.app')

@section('content')
    <h1 class="text-center font-weight-bold">Consultar Formulario 103</h1>

    <div class="card">
        <div class="card-body">
            <a class="btn btn-primary btn-sm text-white" href="/reportes/formulario104"><i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp; <b>Regresar</b></a>
            <br>
            <br>
            <br>
            <input type="text" value="{{$shop_id}}" id="shopId" hidden>
            <div class="form-group row">
                <div class="col-lg-4 col-md-12">
                    <label><b>Año</b></label>&nbsp;&nbsp;
                    <input type="number" id="inputAnio" class="form-control" placeholder="Ingresar año" name="anio" required>
                </div>
                <div class="col-lg-4 col-md-12">
                    <label> <b>Mes</b></label>&nbsp;&nbsp;
                    <select class="form-control" id="selectMes" required>
                    <option value="">Seleccionar Mes</option>
                    @foreach ($meses as $mes => $e)
                        <option value="{{$e}}">{{$mes}}</option>
                    @endforeach
                    </select>
                </div>
            </div>
            <hr>
            <div class="row">
                <button class="btn btn-primary" id="consultar104" onclick="detalleFormulario()">
                <i class="fa fa-search" aria-hidden="true"></i>&nbsp;Consultar
                </button>
            </div>
        </div>
    </div>

<script>
    function detalleFormulario(){
        let shop = document.getElementById("shopId").value;
        let anio = document.getElementById("inputAnio").value;
        let mes = document.getElementById("selectMes").value;

        window.location.href = "/reportes/formulario104/detalle/"+shop+"/"+anio+"/"+mes;
    }
</script>
@endsection