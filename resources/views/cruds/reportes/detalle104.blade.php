@extends('layouts.app')

@section('content')
    <h1 class="text-center font-weight-bold">Detalle Formulario 103</h1>
    <div class="card">
        <div class="card-body">
        <div class="row">
            <div class="col-lg-6 col-md-12 pull-left">
                <a class="btn btn-primary btn-sm text-white" href="/reportes/formulario104"><i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp; <b>Regresar</b></a>
            </div>

            <div class="col-lg-6 col-md-12 pull-right text-right">
                <a class="btn btn-success" href="/reportes/formulario104/generarPDF/{{$shop}}/{{$anio}}/{{$mes}}">
                    <i class="fa fa-file" aria-hidden="true"></i>&nbsp;&nbsp;Generar PDF
                </a>
            </div>
        </div>

            <br><br>
            <div id="accordion">
                <div class="card">
                    <a class="text-white pointer" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true">
                    <div class="card-header bg-primary" id="headingOne">
                        <h5 class="mb-0">
                            <h5>Generaci&oacute;n del impuesto al valor agregado</h5>
                        </h5>
                    </div>
                    </a>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            <table class="table table-striped text-center">
                                <tbody>
                                    <tr>
                                        <td colspan="4"><b>DATOS DEL INFORMANTE</b></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>Identificaci&oacute;n</b>
                                        </td>
                                        <td>
                                            {{$userEmpresa->ruc}}
                                        </td>
                                        <td>
                                            <b>Raz&oacute;n Social</b>
                                        </td>
                                        <td>
                                            {{$userEmpresa->razon_social}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><b>PER&Iacute;ODO A DECLARAR</b></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>Año</b>
                                        </td>
                                        <td>
                                            {{$anio}}
                                        </td>
                                        <td>
                                            <b>Mes</b>
                                        </td>
                                        <td>
                                            {{$nombreMes}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div id="accordionDetalle">
                <div class="card">
                    <a class="text-white pointer" data-toggle="collapse" data-target="#collapseDetalle" aria-expanded="true">
                    <div class="card-header bg-primary" id="headingDetalle">
                        <h5 class="mb-0">
                            <h5>Resumen de ventas y otras operaciones del per&iacute;odo que declara</h5>
                        </h5>
                    </div>
                    </a>

                    <div id="collapseDetalle" class="collapse show" aria-labelledby="headingDetalle" data-parent="#accordionDetalle">
                        <div class="card-body">
                            <table class="table table-striped">
                                <tbody>
                                    <thead>
                                        <tr class="text-center">
                                            <th></th>
                                            <th></th>
                                            <th><b>Valor Bruto</b></th>
                                            <th><b>Valor Neto</b></th>
                                        </tr>
                                    </thead>
                                    @foreach ($categorias as $cat)
                                    <tr>
                                        <td>{{$cat->descripcion}}</td>
                                        <td class="text-center">{{$cat->codigosri}}</td>
                                        <td class="text-right">{{$cat->valorTransaccion}}</td>
                                        <td class="text-right">{{$cat->valorTransaccion}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <td colspan="3"><b>VALOR TOTAL</b></td>
                                    <td><b>${{$total}}</b></td>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row pull-right">
                <a class="btn btn-primary" id="generarXML" href="/reportes/formulario104/generarXML/{{$shop}}/{{$anio}}/{{$mes}}">
                    <i class="fa fa-file" aria-hidden="true"></i>&nbsp;&nbsp;Generar XML
                </a>
            </div>
        </div>
    </div>

<script>
    function detalleFormulario(){
        let empresa = document.getElementById("selectEmpresa").value;
        let anio = document.getElementById("inputAnio").value;
        let mes = document.getElementById("selectMes").value;

        window.location.href = "/reportes/formulario104/detalle/"+empresa+"/"+anio+"/"+mes;
    }
</script>
@endsection