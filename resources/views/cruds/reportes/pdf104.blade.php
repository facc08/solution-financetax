<!DOCTYPE html>
<html>
<head>
    <div class="row">
        <div style="display: inline-block; text-align: left;">
            <img id="imdPDF" alt="logo" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/aegis/source/light/assets/img/solutionlogo.png'))) }}">
        </div>
        <div style="display: inline-block; text-align: right; float:right">Generado por: {{ $nombreUsuario }}&nbsp;-&nbsp;{{$fechaGenerado}}</div>
    </div>
</head>
<style>
footer {
    position: fixed;
    bottom: -60px;
    left: 0px;
    right: 0px;
    height: 50px;
    font-size: 20px !important;
    font-weight: 500;

    /** Extra personal styles **/
    background-color: #d1236d;
    color: white;
    text-align: center;
    line-height: 15px;
}

.pagenum:before {
    content: counter(page);
}

body {
    font-size: 18px;
    font-weight: 400;
    font-family: "Nunito", "Segoe UI", arial;
}

#imdPDF{
    height: 70px;
    width: auto;
}
</style>
<body>
    <footer>
        <p style="text-align: center;">{!! $footer !!}&nbsp;-&nbsp;Página <span class="pagenum"></span></p>
    </footer>
    <br>
    <div class="card">
        <div class="row" style="text-align: center;">
            <h4 style="font-size: 28px">{{ $titulo }}</h4>
        </div>
        <div class="card-body">
            <table class="table table-striped text-center" style="width: 100%; border: 1px solid black; border-collapse: collapse;">
                <tbody>
                    <tr>
                        <td colspan="4" style="background-color: #6777ef; color: white; text-align: center;"><b>DATOS DEL INFORMANTE</b></td>
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
                        <td colspan="4" style="background-color: #6777ef; color: white; text-align: center;"><b>PER&Iacute;ODO A DECLARAR</b></td>
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


    <div class="card">
        <div class="card-body">
            <table class="table table-striped" style="width: 100%; border-collapse: collapse;">
                <tbody>
                    <thead>
                        <tr class="text-center" style="background-color: #6777ef; color: white; text-align: center;">
                            <th style="border: 1px solid black;"><b>DESCRIPCI&Oacute;N</b></th>
                            <th style="border: 1px solid black;"><b>C&Oacute;DIGO SRI</b></th>
                            <th style="border: 1px solid black;"><b>VALOR BRUTO</b></th>
                            <th style="border: 1px solid black;"><b>VALOR NETO</b></th>
                            <th style="border: 1px solid black;"><b>IMPUESTO GENERADO</b></th>
                        </tr>
                    </thead>
                    @foreach ($categorias as $cat)
                    <tr>
                        <td style="border: 1px solid black;">{{$cat->descripcion}}</td>
                        <td style="border: 1px solid black; text-align: center;" class="text-center">{{$cat->codigosri}}</td>
                        <td style="border: 1px solid black; text-align: right;" class="text-right">${{$cat->valorTransaccion}}</td>
                        <td style="border: 1px solid black; text-align: right;" class="text-right">${{$cat->valorTransaccion}}</td>
                        <td style="border: 1px solid black; text-align: right;" class="text-right">${{$cat->porcentaje}}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <td style="border: 1px solid black; text-align: center;" colspan="4"><b>VALOR TOTAL</b></td>
                    <td style="border: 1px solid black; text-align: right;"><b>${{$total}}</b></td>
                </tfoot>
            </table>
        </div>
    </div>
</body>
</html>