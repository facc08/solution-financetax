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

            <div class="form-group row" id="main-div">
                <div class="col-lg-6 col-sm-12">
                    <table class="table" style="width: 100%; border: 1px solid black; border-collapse: collapse;">
                        <thead style="background-color: #6777ef;">
                            <tr>
                                <th style="color: white">Variable</th>
                                <th style="color: white">Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td  style="border: 1px solid black; text-align: center;">BDT</td>
                                <td style="border: 1px solid black; text-align: right;">{{$variables->inputbdt}}</td>
                            </tr>
                            <tr>
                                <td  style="border: 1px solid black; text-align: center;">Amortizaciones</td>
                                <td style="border: 1px solid black; text-align: right;">{{$variables->inputamortizaciones}}</td>
                            </tr>
                            <tr>
                                <td  style="border: 1px solid black; text-align: center;">Ingreso</td>
                                <td style="border: 1px solid black; text-align: right;">{{$variables->inputingreso}}</td>
                            </tr>
                            <tr>
                                <td  style="border: 1px solid black; text-align: center;">Costo</td>
                                <td style="border: 1px solid black; text-align: right;">{{$variables->inputcosto}}</td>
                            </tr>
                            <tr>
                                <td  style="border: 1px solid black; text-align: center;">Gastos fijos</td>
                                <td style="border: 1px solid black; text-align: right;">{{$variables->inputgastosfijos}}</td>
                            </tr>
                            <tr>
                                <td  style="border: 1px solid black; text-align: center;">Margen de Contribución</td>
                                <td style="border: 1px solid black; text-align: right;">{{$variables->inputmargencontribucion}}</td>
                            </tr>
                            <tr>
                                <td  style="border: 1px solid black; text-align: center;">Ventas</td>
                                <td style="border: 1px solid black; text-align: right;">{{$variables->inputventas}}</td>
                            </tr>
                            <tr>
                                <td  style="border: 1px solid black; text-align: center;">Recursos permanentes</td>
                                <td style="border: 1px solid black; text-align: right;">{{$variables->inputrecursospermanentes}}</td>
                            </tr>
                            <tr>
                                <td  style="border: 1px solid black; text-align: center;">Activo no corriente</td>
                                <td style="border: 1px solid black; text-align: right;">{{$variables->inputactivonocorriente}}</td>
                            </tr>
                            <tr>
                                <td  style="border: 1px solid black; text-align: center;">Activo corriente</td>
                                <td style="border: 1px solid black; text-align: right;">{{$variables->inputactivocorriente}}</td>
                            </tr>
                            <tr>
                                <td  style="border: 1px solid black; text-align: center;">Pasivo corriente</td>
                                <td style="border: 1px solid black; text-align: right;">{{$variables->inputpasivocorriente}}</td>
                            </tr>
                            <tr>
                                <td  style="border: 1px solid black; text-align: center;">Recursos ajenos</td>
                                <td style="border: 1px solid black; text-align: right;">{{$variables->inputrecursosajenos}}</td>
                            </tr>
                            <tr>
                                <td  style="border: 1px solid black; text-align: center;">Patrimonio neto y Pasivo</td>
                                <td style="border: 1px solid black; text-align: right;">{{$variables->inputpatrimoniopasivo}}</td>
                            </tr>
                            <tr>
                                <td  style="border: 1px solid black; text-align: center;">Patrimonio neto</td>
                                <td style="border: 1px solid black; text-align: right;">{{$variables->inputpatrimonio}}</td>
                            </tr>
                            <tr>
                                <td  style="border: 1px solid black; text-align: center;">Activo</td>
                                <td style="border: 1px solid black; text-align: right;">{{$variables->inputactivo}}</td>
                            </tr>
                            <tr>
                                <td  style="border: 1px solid black; text-align: center;">BAIT ( Utilidad antes de impuesto )</td>
                                <td style="border: 1px solid black; text-align: right;">{{$variables->inputbait}}</td>
                            </tr>
                            <tr>
                                <td  style="border: 1px solid black; text-align: center;">Fondos propios</td>
                                <td style="border: 1px solid black; text-align: right;">{{$variables->inputfondospropios}}</td>
                            </tr>
                            <tr>
                                <td  style="border: 1px solid black; text-align: center;">BAT ( Utilidad después del gasto financiero )</td>
                                <td style="border: 1px solid black; text-align: right;">{{$variables->inputbat}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <br>
                <br>

                <div class="col-lg-6 col-sm-12">
                    <table class="table table-striped" style="width: 100%; border: 1px solid black; border-collapse: collapse;">
                        <thead style="background-color: #6777ef;">
                            <tr>
                                <th colspan="2" style="color: white"><h5>Análisis Económico</h5></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="border: 1px solid black; text-align: center;">
                                    <p><b>Autofinanciación</b></p>
                                    <p style="font-size: 14px;">( BDT + Amortizaciones )</p>
                                </td>
                                <td  style="border: 1px solid black; text-align: right;">${{$formulas->valautofinanciacion}}</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black; text-align: center;">
                                    <p><b>Margen de Contribución</b></p>
                                    <p style="font-size: 14px;">( Ingresos / Costos )</p>
                                </td>
                                <td  style="border: 1px solid black; text-align: right;">${{$formulas->valmargencontribucion}}</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black; text-align: center;">
                                    <p><b>Umbral de rentabilidad</b></p>
                                    <p style="font-size: 14px;">( Gastos fijos / Margen de contribución )</p>
                                </td>
                                <td  style="border: 1px solid black; text-align: right;">${{$formulas->valumbralrentabilidad}}</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black; text-align: center;">
                                    <p><b>Margen seguridad comercial</b></p>
                                    <p style="font-size: 14px;">( Ventas - Umbral de rentabilidad ) / Ventas</p>
                                </td>
                                <td  style="border: 1px solid black; text-align: right;">${{$formulas->valumbralmargenseguridad}}</td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-striped" style="width: 100%; border: 1px solid black; border-collapse: collapse;">
                        <thead style="background-color: #6777ef;">
                            <tr>
                                <th colspan="2" style="color: white"><h5>Análisis Patrimonial y Financiero</h5></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="border: 1px solid black; text-align: center;">
                                    <p><b>Coeficiente financiero activo no corriente</b></p>
                                    <p style="font-size: 14px;">( Recursos permanentes / Activo no corriente )</p>
                                </td>
                                <td  style="border: 1px solid black; text-align: right;">${{$formulas->valcoeficientefinanciero}}</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black; text-align: center;">
                                    <p><b>Fondo de maniobra</b></p>
                                    <p style="font-size: 14px;">( Recursos permanentes - Activo no corriente )</p>
                                </td>
                                <td  style="border: 1px solid black; text-align: right;">${{$formulas->valfondomaniobra}}</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black; text-align: center;">
                                    <p><b>Coeficiente de liquidez</b></p>
                                    <p style="font-size: 14px;">( Activo corriente / Pasivo corriente )</p>
                                </td>
                                <td  style="border: 1px solid black; text-align: right;">${{$formulas->valcoeficienteliquidez}}</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black; text-align: center;">
                                    <p><b>Endeudamiento</b></p>
                                    <p style="font-size: 14px;">( Recursos ajenos / Patrimonio neto y Pasivo )</p>
                                </td>
                                <td  style="border: 1px solid black; text-align: right;">${{$formulas->valendeudamiento}}</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black; text-align: center;">
                                    <p><b>Autonomía</b></p>
                                    <p style="font-size: 14px;">( Patrimonio neto / Patrimonio neto y Pasivo )</p>
                                </td>
                                <td  style="border: 1px solid black; text-align: right;">${{$formulas->valautonomia}}</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black; text-align: center;">
                                    <p><b>Solvencia total</b></p>
                                    <p style="font-size: 14px;">( Activo / Recursos ajenos )</p>
                                </td>
                                <td  style="border: 1px solid black; text-align: right;">${{$formulas->valsolvenciatotal}}</td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-striped" style="width: 100%; border: 1px solid black; border-collapse: collapse;">
                        <thead style="background-color: #6777ef;">
                            <tr>
                                <th colspan="2" style="color: white"><h5>Análisis Rentabilidad y Riesgo Financiero</h5></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="border: 1px solid black; text-align: center;">
                                    <p><b>Rentabilidad económica</b></p>
                                    <p style="font-size: 14px;">( BAIT / Activo )</p>
                                </td>
                                <td  style="border: 1px solid black; text-align: right;">${{$formulas->valrentabilidadeconomica}}</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black; text-align: center;">
                                    <p><b>Efecto margen</b></p>
                                    <p style="font-size: 14px;">( BAIT / Ventas )</p>
                                </td>
                                <td  style="border: 1px solid black; text-align: right;">${{$formulas->valefectomargen}}</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black; text-align: center;">
                                    <p><b>Efecto rotación</b></p>
                                    <p style="font-size: 14px;">( Ventas / Activo )</p>
                                </td>
                                <td  style="border: 1px solid black; text-align: right;">${{$formulas->valefectorotacion}}</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black; text-align: center;">
                                    <p><b>Rentabilidad financiera</b></p>
                                    <p style="font-size: 14px;">( BDT / Fondos propios )</p>
                                </td>
                                <td  style="border: 1px solid black; text-align: right;">${{$formulas->valrentabilidadfinanciera}}</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black; text-align: center;">
                                    <p><b>Apalancamiento financiero</b></p>
                                    <p style="font-size: 14px;">( Activo / Fondos propios ) * ( BAT / BAIT )</p>
                                </td>
                                <td  style="border: 1px solid black; text-align: right;">${{$formulas->valapalancamientofinanciero}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
    </div>
</body>
</html>