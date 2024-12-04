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
            <h3 style="font-size: 28px">{{ $titulo }}</h3>
        </div>
        <div class="card-body">
            <div class="form-group" id="main-div" style="text-align: center">
                <div class="row" style="text-align: center">
                    <h4 style="font-size: 22px">{{$formula->nombre}}</h4>
                    <p style="font-size: 18px">{{$formula->descripcion}}</p>
                    <br>
                </div>
                <br>
                <div class="row" style="text-align: center">
                    <table class="table" style="width: 100%; border: 0px;">
                        <thead style="background-color: #6777ef;">
                            <tr>
                                <th style="color: white" colspan="2"><b>{{$formula->formula}}</b></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="border: 0px; text-align: center;"><b>{{$variables->numerador->label}}&nbsp;&nbsp;&nbsp;=</b></td>
                                <td style="border: 0px; text-align: center;">{{$variables->numerador->valor}}</td>
                            </tr>
                            <tr>
                                <hr style="width: 50%; border: 1px solid grey;">
                            </tr>
                            <tr>
                                <td style="border: 0px; text-align: center;"><b>{{$variables->denominador->label}}&nbsp;&nbsp;&nbsp;=</b></td>
                                <td style="border: 0px; text-align: center;">{{$variables->denominador->valor}}</td>
                            </tr>
                            <br>
                            <br>
                            <tr>
                                <td style="border: 0px; text-align: center;"><b style="font-size: 18px">TOTAL&nbsp;&nbsp;&nbsp;=</b></td>
                                <td style="border: 0px; text-align: center;"><b style="font-size: 18px">{{$variables->resultado}}</b></td>
                            </tr>
                        </tbody>
                        <br>
                        <br>
                        <tfoot>
                            <tr>
                                <td colspan="2" style="font-size: 18px">{{$formula->observacion}}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <br>
            </div>
        </div>
    </div>
</body>
</html>