@extends('layouts.app')

@section('content')
    <h1 class="text-center font-weight-bold">Detalle Indicadores</h1>

    <div class="card">
        <div class="card-body">
            <a class="btn btn-primary btn-sm text-white" href="/reportes/indicadores"><i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp; <b>Regresar</b></a>
            <br>
            <br>
            <br>
            <input type="number" id="inputShop" value="{{$shop}}" hidden>
            <div class="form-group row">
                @foreach($formulas as $for)
                <div class="col-lg-4 col-sm-6">
                    <div class="card-box bg-light text-dark">
                        <div class="inner">
                            <h4> {{$for->nombre}} </h4>
                            <p>{{$for->descripcion}}</p>
                        </div>
                        <button type="button" id="btnModal" class="btn btn-primary" data-id="{{$for->id}}" data-formula="{{$for->formula}}"
                        data-descripcion="{{$for->descripcion}}" data-observacion="{{$for->observacion}}" onclick='openModal(this)'>
                            <i class="fa fa-search" aria-hidden="true"></i>&nbsp;Realizar C&aacute;lculo
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-modal="true"
                role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">C&aacute;lculo Indicador</h5>
                            <button type="button" class="close" aria-label="Close" onclick="closeModal()">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                                <input type="number" id="inputId" value="" hidden>
                                <div class="row">
                                    <label for="" id="labelNumerador"></label>
                                    <input type="number" class="form-control" placeholder="$" id="inputNumerador" onkeyup="cambiaFormula(this)">
                                </div>
                                <hr style="border: 1px solid grey;">
                                <div class="row">
                                    <label for="" id="labelDenominador"></label>
                                    <input type="number" class="form-control" placeholder="$" id="inputDenominador" onkeyup="cambiaFormula(this)">
                                </div>
                                <br>
                                <div class="row">
                                    <button type="button" class="btn btn-primary" id="btnCalcularFormula" onclick="calcularFormula(this)">Calcular</button>
                                </div>
                                <br>
                                <br>
                                <div class="row">
                                    <label for="" id="labelResultado">Resultado</label>
                                    <input type="number" class="form-control" placeholder="$" id="inputResultado" disabled>
                                </div>
                                <br>
                                <div class="row">
                                    <label for="" id="labelObservaciones"></label>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <a class="btn btn-success" href="" id="btnGenerarPdf" hidden>
                                <i class="fa fa-file" aria-hidden="true"></i>&nbsp;&nbsp;Generar PDF
                            </a>
                            <button type="button" class="btn btn-secondary" onclick="closeModal()">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-backdrop fade show" id="backdrop" style="display: none;"></div>

        </div>
    </div>
    <script>
        document.getElementById("btnCalcularFormula").disabled = true;

        function openModal(element) {
            document.getElementById("backdrop").style.display = "block"
            document.getElementById("exampleModal").style.display = "block"
            document.getElementById("exampleModal").classList.add("show")

            var formula = element.getAttribute('data-formula');
            var arrayFormula = formula.split("/");

            document.getElementById("labelObservaciones").innerHTML = element.getAttribute('data-observacion');
            document.getElementById("labelNumerador").innerHTML = arrayFormula[0];
            document.getElementById("labelDenominador").innerHTML = arrayFormula[1];

            document.getElementById("inputId").value = element.getAttribute('data-id');

            //document.getElementById("formula-modal").innerHTML = element.getAttribute('data-formula');
        }

        function cambiaFormula(element){
            var numerador = document.getElementById("inputNumerador").value;
            var denominador = document.getElementById("inputDenominador").value;

            /*
            var flagNumerador = true;
            var flagDenominador = true;

            if(numerador == ''){
                flagNumerador = false;
            }

            if(denominador == ''){
                flagDenominador = false;
            }

            console.log(flagNumerador);
                console.log(flagDenominador);
            */

            if(numerador !== '' && denominador !== ''){
                /*if(denominador > 0){
                    document.getElementById("inputResultado").value = numerador/denominador;
                }*/
                document.getElementById("btnCalcularFormula").disabled = false;
            }
        }

        function calcularFormula(element){
            var numerador = document.getElementById("inputNumerador").value;
            var denominador = document.getElementById("inputDenominador").value;
            var stringJsonFormulas = "";

            if(numerador !== "" && denominador.lenght !== ""){

                document.getElementById("inputResultado").value = numerador/denominador;

                document.getElementById("btnGenerarPdf").removeAttribute("hidden");
                var idFormula = document.getElementById("inputId").value;
                var idShop = document.getElementById("inputShop").value;
                var labelNumerador = document.getElementById("labelNumerador").innerHTML;
                var labelDenominador = document.getElementById("labelDenominador").innerHTML;

                stringJsonFormulas += '"numerador":{"label":"'+labelNumerador+'","valor":'+numerador+'},';
                stringJsonFormulas += '"denominador":{"label":"'+labelDenominador+'","valor":'+denominador+'},';
                stringJsonFormulas += '"resultado":'+document.getElementById("inputResultado").value;
                stringJsonFormulas = "{" + stringJsonFormulas;
                stringJsonFormulas = stringJsonFormulas + "}";

                document.getElementById("btnGenerarPdf").href = "/reportes/indicadores/generarPDF/"+idShop+"/"+idFormula+"/"+stringJsonFormulas;
            }
        }

        function closeModal() {
            document.getElementById("backdrop").style.display = "none"
            document.getElementById("exampleModal").style.display = "none"
            //document.getElementById("formula-modal").innerHTML = '';
            document.getElementById("labelNumerador").innerHTML = '';
            document.getElementById("labelDenominador").innerHTML = '';
            document.getElementById("btnCalcularFormula").disabled = true;
            document.getElementById("inputNumerador").value = '';
            document.getElementById("inputDenominador").value = '';
            document.getElementById("inputResultado").value = '';

            document.getElementById("btnGenerarPdf").setAttribute("hidden");
            document.getElementById("btnGenerarPdf").href = "";
            document.getElementById("inputId").value = "";

            document.getElementById("exampleModal").classList.remove("show");
        }

        var modal = document.getElementById('exampleModal');

        window.onclick = function(event) {
            if (event.target == modal) {
                closeModal()
            }
        }
    </script>
@endsection