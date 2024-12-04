@extends('layouts.app')

@section('content')
    <h1 class="text-center font-weight-bold">Detalle Indicadores</h1>

    <div class="card">
        <div class="card-body">
            <a class="btn btn-primary btn-sm text-white" href="/reportes/indicadores"><i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp; <b>Regresar</b></a>
            <br>
            <br>
            <br>

            <div class="form-group row">
                @foreach($formulas as $for)
                <div class="col-lg-4 col-sm-6">
                    <div class="card-box bg-light text-dark">
                        <div class="inner">
                            <h4> {{$for->descripcion}} </h4>
                            <p> {{$for->formulaValor}} </p>
                        </div>
                        <button type="button" class="btn btn-primary" data-formula="{{$for->formulaLimpia}}" onclick='openModal(this)'>
                            <i class="fa fa-search" aria-hidden="true"></i>&nbsp;Detalles
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
                            <h5 class="modal-title" id="exampleModalLabel">Detalle Indicador</h5>
                            <button type="button" class="close" aria-label="Close" onclick="closeModal()">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <span id="formula-modal"></span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" onclick="closeModal()">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-backdrop fade show" id="backdrop" style="display: none;"></div>

        </div>
    </div>
    <script>
        function openModal(element) {
            document.getElementById("backdrop").style.display = "block"
            document.getElementById("exampleModal").style.display = "block"
            document.getElementById("exampleModal").classList.add("show")

            document.getElementById("formula-modal").innerHTML = element.getAttribute('data-formula');
        }
        function closeModal() {
            document.getElementById("backdrop").style.display = "none"
            document.getElementById("exampleModal").style.display = "none"
            document.getElementById("formula-modal").innerHTML = '';
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