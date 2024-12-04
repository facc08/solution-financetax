@extends('layouts.app')

@section('content')
    <h1 class="text-center font-weight-bold">Detalle Ratios</h1>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col-md-12 pull-left">
                    <a class="btn btn-primary btn-sm text-white" href="/reportes/ratios"><i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp; <b>Regresar</b></a>
                </div>

                <div class="col-lg-6 col-md-12 pull-right text-right">
                    <a class="btn btn-success text-white" onclick="printDiv()"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;&nbsp;<b>Generar PDF</b></a>
                    <a class="btn btn-success text-white" href="" hidden id="getPdf"></a>
                </div>
            </div>
            <br>
            <br>
            <div class="row">
                <div class="col-lg-12 col-md-12 text-center">
                    <button type="button" class="btn btn-primary" onclick='limpiarDatos()'>
                        <i class="fa fa-eraser" aria-hidden="true"></i>&nbsp;Limpiar Datos
                    </button>
                </div>
            </div>
            <br>
            <br>
            <input type="number" id="input-shop" value="{{$shop}}" hidden>
            <div class="form-group row" id="main-div">
                <div class="col-lg-6 col-sm-12">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>BDT</td>
                                <td><input type="number" class="input-variable" id="input-bdt" onkeyup="cambiaFormula(this)"></td>
                            </tr>
                            <tr>
                                <td>Amortizaciones</td>
                                <td><input type="number" class="input-variable" id="input-amortizaciones" onkeyup="cambiaFormula(this)"></td>
                            </tr>
                            <tr>
                                <td>Ingreso</td>
                                <td><input type="number" class="input-variable" id="input-ingreso" onkeyup="cambiaFormula(this)"></td>
                            </tr>
                            <tr>
                                <td>Costo</td>
                                <td><input type="number" class="input-variable" id="input-costo" onkeyup="cambiaFormula(this)"></td>
                            </tr>
                            <tr>
                                <td>Gastos fijos</td>
                                <td><input type="number" class="input-variable" id="input-gastos-fijos" onkeyup="cambiaFormula(this)"></td>
                            </tr>
                            <tr>
                                <td>Margen de Contribución</td>
                                <td><input type="number" class="input-variable" id="input-margen-contribucion" onkeyup="cambiaFormula(this)"></td>
                            </tr>
                            <tr>
                                <td>Ventas</td>
                                <td><input type="number" class="input-variable" id="input-ventas" onkeyup="cambiaFormula(this)"></td>
                            </tr>
                            <tr>
                                <td>Recursos permanentes</td>
                                <td><input type="number" class="input-variable" id="input-recursos-permanentes" onkeyup="cambiaFormula(this)"></td>
                            </tr>
                            <tr>
                                <td>Activo no corriente</td>
                                <td><input type="number" class="input-variable" id="input-activo-no-corriente" onkeyup="cambiaFormula(this)"></td>
                            </tr>
                            <tr>
                                <td>Activo corriente</td>
                                <td><input type="number" class="input-variable" id="input-activo-corriente" onkeyup="cambiaFormula(this)"></td>
                            </tr>
                            <tr>
                                <td>Pasivo corriente</td>
                                <td><input type="number" class="input-variable" id="input-pasivo-corriente" onkeyup="cambiaFormula(this)"></td>
                            </tr>
                            <tr>
                                <td>Recursos ajenos</td>
                                <td><input type="number" class="input-variable" id="input-recursos-ajenos" onkeyup="cambiaFormula(this)"></td>
                            </tr>
                            <tr>
                                <td>Patrimonio neto y Pasivo</td>
                                <td><input type="number" class="input-variable" id="input-patrimonio-pasivo" onkeyup="cambiaFormula(this)"></td>
                            </tr>
                            <tr>
                                <td>Patrimonio neto</td>
                                <td><input type="number" class="input-variable" id="input-patrimonio" onkeyup="cambiaFormula(this)"></td>
                            </tr>
                            <tr>
                                <td>Activo</td>
                                <td><input type="number" class="input-variable" id="input-activo" onkeyup="cambiaFormula(this)"></td>
                            </tr>
                            <tr>
                                <td>BAIT ( Utilidad antes de impuesto )</td>
                                <td><input type="number" class="input-variable" id="input-bait" onkeyup="cambiaFormula(this)"></td>
                            </tr>
                            <tr>
                                <td>Fondos propios</td>
                                <td><input type="number" class="input-variable" id="input-fondos-propios" onkeyup="cambiaFormula(this)"></td>
                            </tr>
                            <tr>
                                <td>BAT ( Utilidad después del gasto financiero )</td>
                                <td><input type="number" class="input-variable" id="input-bat" onkeyup="cambiaFormula(this)"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-lg-6 col-sm-12">
                    <table class="table table-striped">
                        <thead style="background-color: #6777ef;">
                            <tr>
                                <th colspan="2" style="color: white"><h5>Análisis Económico</h5></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <p><b>Autofinanciación</b></p>
                                    <p style="font-size: 14px;">( BDT + Amortizaciones )</p>
                                </td>
                                <td>$<span id="val-autofinanciacion"></span></td>
                            </tr>
                            <tr>
                                <td>
                                    <p><b>Margen de Contribución</b></p>
                                    <p style="font-size: 14px;">( Ingresos / Costos )</p>
                                </td>
                                <td>$<span id="val-margen-contribucion"></span></td>
                            </tr>
                            <tr>
                                <td>
                                    <p><b>Umbral de rentabilidad</b></p>
                                    <p style="font-size: 14px;">( Gastos fijos / Margen de contribución )</p>
                                </td>
                                <td>$<span id="val-umbral-rentabilidad"></span></td>
                            </tr>
                            <tr>
                                <td>
                                    <p><b>Margen seguridad comercial</b></p>
                                    <p style="font-size: 14px;">( Ventas - Umbral de rentabilidad ) / Ventas</p>
                                </td>
                                <td>$<span id="val-umbral-margen-seguridad"></span></td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-striped">
                        <thead style="background-color: #6777ef;">
                            <tr>
                                <th colspan="2" style="color: white"><h5>Análisis Patrimonial y Financiero</h5></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <p><b>Coeficiente financiero activo no corriente</b></p>
                                    <p style="font-size: 14px;">( Recursos permanentes / Activo no corriente )</p>
                                </td>
                                <td>$<span id="val-coeficiente-financiero"></span></td>
                            </tr>
                            <tr>
                                <td>
                                    <p><b>Fondo de maniobra</b></p>
                                    <p style="font-size: 14px;">( Recursos permanentes - Activo no corriente )</p>
                                </td>
                                <td>$<span id="val-fondo-maniobra"></span></td>
                            </tr>
                            <tr>
                                <td>
                                    <p><b>Coeficiente de liquidez</b></p>
                                    <p style="font-size: 14px;">( Activo corriente / Pasivo corriente )</p>
                                </td>
                                <td>$<span id="val-coeficiente-liquidez"></span></td>
                            </tr>
                            <tr>
                                <td>
                                    <p><b>Endeudamiento</b></p>
                                    <p style="font-size: 14px;">( Recursos ajenos / Patrimonio neto y Pasivo )</p>
                                </td>
                                <td>$<span id="val-endeudamiento"></span></td>
                            </tr>
                            <tr>
                                <td>
                                    <p><b>Autonomía</b></p>
                                    <p style="font-size: 14px;">( Patrimonio neto / Patrimonio neto y Pasivo )</p>
                                </td>
                                <td>$<span id="val-autonomia"></span></td>
                            </tr>
                            <tr>
                                <td>
                                    <p><b>Solvencia total</b></p>
                                    <p style="font-size: 14px;">( Activo / Recursos ajenos )</p>
                                </td>
                                <td>$<span id="val-solvencia-total"></span></td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-striped">
                        <thead style="background-color: #6777ef;">
                            <tr>
                                <th colspan="2" style="color: white"><h5>Análisis Rentabilidad y Riesgo Financiero</h5></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <p><b>Rentabilidad económica</b></p>
                                    <p style="font-size: 14px;">( BAIT / Activo )</p>
                                </td>
                                <td>$<span id="val-rentabilidad-economica"></span></td>
                            </tr>
                            <tr>
                                <td>
                                    <p><b>Efecto margen</b></p>
                                    <p style="font-size: 14px;">( BAIT / Ventas )</p>
                                </td>
                                <td>$<span id="val-efecto-margen"></span></td>
                            </tr>
                            <tr>
                                <td>
                                    <p><b>Efecto rotación</b></p>
                                    <p style="font-size: 14px;">( Ventas / Activo )</p>
                                </td>
                                <td>$<span id="val-efecto-rotacion"></span></td>
                            </tr>
                            <tr>
                                <td>
                                    <p><b>Rentabilidad financiera</b></p>
                                    <p style="font-size: 14px;">( BDT / Fondos propios )</p>
                                </td>
                                <td>$<span id="val-rentabilidad-financiera"></span></td>
                            </tr>
                            <tr>
                                <td>
                                    <p><b>Apalancamiento financiero</b></p>
                                    <p style="font-size: 14px;">( Activo / Fondos propios ) * ( BAT / BAIT )</p>
                                </td>
                                <td>$<span id="val-apalancamiento-financiero"></span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
    <script>
        function printDiv() {

            var arrayVariables = [
                "input-bdt",
                "input-amortizaciones",
                "input-ingreso",
                "input-costo",
                "input-gastos-fijos",
                "input-margen-contribucion",
                "input-ventas",
                "input-recursos-permanentes",
                "input-activo-no-corriente",
                "input-activo-corriente",
                "input-pasivo-corriente",
                "input-recursos-ajenos",
                "input-patrimonio-pasivo",
                "input-patrimonio",
                "input-activo",
                "input-bait",
                "input-fondos-propios",
                "input-bat"
            ];

            var stringJson = "";

            arrayVariables.forEach(function (item, index) {
                var itemVar = "";
                var variable = document.getElementById(item).value;
                itemVar = item.replace(/-/g, '');

                if(variable.length !== 0){
                    stringJson += '"'+itemVar+'":'+variable+','
                }else{
                    stringJson += '"'+itemVar+'":"-",'
                }
            });

            stringJson = "{" + stringJson;
            stringJson = stringJson.slice(0,- 1);
            stringJson = stringJson + "}";

            var arrayFormulas = [
                "val-autofinanciacion",
                "val-margen-contribucion",
                "val-umbral-rentabilidad",
                "val-umbral-margen-seguridad",
                "val-coeficiente-financiero",
                "val-fondo-maniobra",
                "val-coeficiente-liquidez",
                "val-endeudamiento",
                "val-autonomia",
                "val-solvencia-total",
                "val-rentabilidad-economica",
                "val-efecto-margen",
                "val-efecto-rotacion",
                "val-rentabilidad-financiera",
                "val-apalancamiento-financiero"
            ];

            var stringJsonFormulas = "";

            arrayFormulas.forEach(function (item, index) {
                var formula = document.getElementById(item).innerText;
                var itemFor = item.replace(/-/g, '');

                if(formula.length !== 0){
                    stringJsonFormulas += '"'+itemFor+'":'+formula+','
                }else{
                    stringJsonFormulas += '"'+itemFor+'":"-",'
                }
            });

            stringJsonFormulas = "{" + stringJsonFormulas;
            stringJsonFormulas = stringJsonFormulas.slice(0,- 1);
            stringJsonFormulas = stringJsonFormulas + "}";

            var shop = document.getElementById("input-shop").value;

            var linkPdf = document.getElementById('getPdf');
            linkPdf.href = "/reportes/ratios/generarPDF/"+shop+"/"+stringJson+"/"+stringJsonFormulas;

            linkPdf.click();
        }

        function cambiaFormula(element){
            var bdt = document.getElementById("input-bdt").value;
            var amortizaciones = document.getElementById("input-amortizaciones").value;
            var ingreso = document.getElementById("input-ingreso").value;
            var costo = document.getElementById("input-costo").value;
            var gastosFijos = document.getElementById("input-gastos-fijos").value;
            var margenContribucion = document.getElementById("input-margen-contribucion").value;
            var ventas = document.getElementById("input-ventas").value;

            var recursosPermanentes = document.getElementById("input-recursos-permanentes").value;
            var activoNoCorriente = document.getElementById("input-activo-no-corriente").value;
            var activoCorriente = document.getElementById("input-activo-corriente").value;
            var pasivoCorriente = document.getElementById("input-pasivo-corriente").value;
            var recursosAjenos = document.getElementById("input-recursos-ajenos").value;
            var patrimonioPasivo = document.getElementById("input-patrimonio-pasivo").value;
            var patrimonio = document.getElementById("input-patrimonio").value;
            var activo = document.getElementById("input-activo").value;

            var bait = document.getElementById("input-bait").value;
            var fondosPropios = document.getElementById("input-fondos-propios").value;
            var bat = document.getElementById("input-bat").value;

            if(bdt.length !== 0 && amortizaciones.length !== 0){
                document.getElementById("val-autofinanciacion").innerHTML = parseFloat(parseInt(bdt)+parseInt(amortizaciones)).toFixed(2);
            }

            if(ingreso.length !== 0 && costo.length !== 0){

                let valorFormula = parseFloat(parseInt(ingreso)/parseInt(costo)).toFixed(2);

                if(isNaN(valorFormula) || !isFinite(valorFormula)){
                    document.getElementById("val-margen-contribucion").innerHTML = parseFloat(0).toFixed(2);
                }else{
                    document.getElementById("val-margen-contribucion").innerHTML = valorFormula;
                }
            }

            if(gastosFijos.length !== 0 && margenContribucion.length !== 0){

                let valorFormula = parseFloat(parseInt(gastosFijos)/parseInt(margenContribucion)).toFixed(2);

                if(isNaN(valorFormula) || !isFinite(valorFormula)){
                    document.getElementById("val-umbral-rentabilidad").innerHTML = parseFloat(0).toFixed(2);
                }else{
                    document.getElementById("val-umbral-rentabilidad").innerHTML = valorFormula;
                }
            }

            if(ventas.length !== 0 && gastosFijos.length !== 0 && margenContribucion.length !== 0){

                let valorFormula = parseFloat((parseInt(ventas)-(parseInt(gastosFijos)/parseInt(margenContribucion)))/parseInt(ventas)).toFixed(2);

                if(isNaN(valorFormula) || !isFinite(valorFormula)){
                    document.getElementById("val-umbral-margen-seguridad").innerHTML = parseFloat(0).toFixed(2);
                }else{
                    document.getElementById("val-umbral-margen-seguridad").innerHTML = valorFormula;
                }
            }

            if(recursosPermanentes.length !== 0 && activoNoCorriente.length !== 0){

                let valorFormula = parseFloat(parseInt(recursosPermanentes)/parseInt(activoNoCorriente)).toFixed(2);

                if(isNaN(valorFormula) || !isFinite(valorFormula)){
                    document.getElementById("val-coeficiente-financiero").innerHTML = parseFloat(0).toFixed(2);
                }else{
                    document.getElementById("val-coeficiente-financiero").innerHTML = valorFormula;
                }
            }

            if(recursosPermanentes.length !== 0 && activoNoCorriente.length !== 0){

                let valorFormula = parseFloat(parseInt(recursosPermanentes)-parseInt(activoNoCorriente)).toFixed(2);

                if(isNaN(valorFormula) || !isFinite(valorFormula)){
                    document.getElementById("val-fondo-maniobra").innerHTML = parseFloat(0).toFixed(2);
                }else{
                    document.getElementById("val-fondo-maniobra").innerHTML = valorFormula;
                }
            }

            if(recursosPermanentes.length !== 0 && activoNoCorriente.length !== 0){

                let valorFormula = parseFloat(parseInt(activoCorriente)/parseInt(pasivoCorriente)).toFixed(2);

                if(isNaN(valorFormula) || !isFinite(valorFormula)){
                    document.getElementById("val-coeficiente-liquidez").innerHTML = parseFloat(0).toFixed(2);
                }else{
                    document.getElementById("val-coeficiente-liquidez").innerHTML = valorFormula;
                }
            }

            if(recursosAjenos.length !== 0 && patrimonioPasivo.length !== 0){

                let valorFormula = parseFloat(parseInt(recursosAjenos)/parseInt(patrimonioPasivo)).toFixed(2);

                if(isNaN(valorFormula) || !isFinite(valorFormula)){
                    document.getElementById("val-endeudamiento").innerHTML = parseFloat(0).toFixed(2);
                }else{
                    document.getElementById("val-endeudamiento").innerHTML = valorFormula;
                }
            }

            if(patrimonio.length !== 0 && patrimonioPasivo.length !== 0){

                let valorFormula = parseFloat(parseInt(patrimonio)/parseInt(patrimonioPasivo)).toFixed(2);

                if(isNaN(valorFormula) || !isFinite(valorFormula)){
                    document.getElementById("val-autonomia").innerHTML = parseFloat(0).toFixed(2);
                }else{
                    document.getElementById("val-autonomia").innerHTML = valorFormula;
                }
            }

            if(activo.length !== 0 && recursosAjenos.length !== 0){

                let valorFormula = parseFloat(parseInt(activo)/parseInt(recursosAjenos)).toFixed(2);

                if(isNaN(valorFormula) || !isFinite(valorFormula)){
                    document.getElementById("val-solvencia-total").innerHTML = parseFloat(0).toFixed(2);
                }else{
                    document.getElementById("val-solvencia-total").innerHTML = valorFormula;
                }
            }

            if(activo.length !== 0 && bait.length !== 0){

                let valorFormula = parseFloat(parseInt(bait)/parseInt(activo)).toFixed(2);

                if(isNaN(valorFormula) || !isFinite(valorFormula)){
                    document.getElementById("val-rentabilidad-economica").innerHTML = parseFloat(0).toFixed(2);
                }else{
                    document.getElementById("val-rentabilidad-economica").innerHTML = valorFormula;
                }
            }

            if(bait.length !== 0 && ventas.length !== 0){

                let valorFormula = parseFloat(parseInt(bait)/parseInt(ventas)).toFixed(2);

                if(isNaN(valorFormula) || !isFinite(valorFormula)){
                    document.getElementById("val-efecto-margen").innerHTML = parseFloat(0).toFixed(2);
                }else{
                    document.getElementById("val-efecto-margen").innerHTML = valorFormula;
                }
            }

            if(ventas.length !== 0 && activo.length !== 0){

                let valorFormula = parseFloat(parseInt(ventas)/parseInt(activo)).toFixed(2);

                if(isNaN(valorFormula) || !isFinite(valorFormula)){
                    document.getElementById("val-efecto-rotacion").innerHTML = parseFloat(0).toFixed(2);
                }else{
                    document.getElementById("val-efecto-rotacion").innerHTML = valorFormula;
                }
            }

            if(bdt.length !== 0 && fondosPropios.length !== 0){

                let valorFormula = parseFloat(parseInt(bdt)/parseInt(fondosPropios)).toFixed(2);

                if(isNaN(valorFormula) || !isFinite(valorFormula)){
                    document.getElementById("val-rentabilidad-financiera").innerHTML = parseFloat(0).toFixed(2);
                }else{
                    document.getElementById("val-rentabilidad-financiera").innerHTML = valorFormula;
                }
            }

            if(activo.length !== 0 && fondosPropios.length !== 0 && bat.length !== 0 && bait.length !== 0){

                let valorFormula = parseFloat((parseInt(activo)/parseInt(fondosPropios))*(parseInt(bat)/parseInt(bait))).toFixed(2);

                if(isNaN(valorFormula) || !isFinite(valorFormula)){
                    document.getElementById("val-apalancamiento-financiero").innerHTML = parseFloat(0).toFixed(2);
                }else{
                    document.getElementById("val-apalancamiento-financiero").innerHTML = valorFormula;
                }
            }

        }

        function limpiarDatos(){
            var arrayVariables = [
                "input-bdt",
                "input-amortizaciones",
                "input-ingreso",
                "input-costo",
                "input-gastos-fijos",
                "input-margen-contribucion",
                "input-ventas",
                "input-recursos-permanentes",
                "input-activo-no-corriente",
                "input-activo-corriente",
                "input-pasivo-corriente",
                "input-recursos-ajenos",
                "input-patrimonio-pasivo",
                "input-patrimonio",
                "input-activo",
                "input-bait",
                "input-fondos-propios",
                "input-bat"
            ];

            arrayVariables.forEach(function (item, index) {
                document.getElementById(item).value = '';
            });

            var arrayFormulas = [
                "val-autofinanciacion",
                "val-margen-contribucion",
                "val-umbral-rentabilidad",
                "val-umbral-margen-seguridad",
                "val-coeficiente-financiero",
                "val-fondo-maniobra",
                "val-coeficiente-liquidez",
                "val-endeudamiento",
                "val-autonomia",
                "val-solvencia-total",
                "val-rentabilidad-economica",
                "val-efecto-margen",
                "val-efecto-rotacion",
                "val-rentabilidad-financiera",
                "val-apalancamiento-financiero"
            ];

            arrayFormulas.forEach(function (item, index) {
                document.getElementById(item).innerText = '';
            });
        }

    </script>
@endsection