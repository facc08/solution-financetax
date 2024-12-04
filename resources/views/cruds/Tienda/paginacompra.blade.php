@extends('layouts.app')

@section('content')
    <script src="https://pay.payphonetodoesposible.com/api/button/js?appId=VavCoVkk0yNzrf01l3cA"></script>
    <style>
        .info-box {
            box-shadow: 0 0 1px rgb(0 0 0 / 13%), 0 1px 3px rgb(0 0 0 / 20%);
            border-radius: 0.25rem;
            background-color: #fff;
            display: -ms-flexbox;
            display: flex;
            margin-bottom: 1rem;
            min-height: 80px;
            padding: 0.5rem;
            position: relative;
            width: 100%;
        }

        .mb-3, .my-3 {
            margin-bottom: 1rem!important;
        }

        .info-box .info-box-icon {
            border-radius: 0.25rem;
            -ms-flex-align: center;
            align-items: center;
            display: -ms-flexbox;
            display: flex;
            /*font-size: 1.875rem !important;*/
            font-size: 2.5rem !important;
            -ms-flex-pack: center;
            justify-content: center;
            text-align: center;
            width: 70px;
            color: white;
            font-weight: 700;
        }


        .info-box .info-box-content {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            -ms-flex-pack: center;
            justify-content: center;
            line-height: 1.8;
            -ms-flex: 1;
            flex: 1;
            padding: 0 10px;
            overflow: hidden;
            color: white;
        }

        .info-box .info-box-text, .info-box .progress-description {
            display: block;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .card{
            border-color: #6777ef !important;
            border-width: medium;
        }

        .theme-white .nav-tabs .nav-item .nav-link .active{
            color: none !important;
        }

        .nav-tabs .nav-item .nav-link.active {
            color: #6777ef !important;
        }

    </style>
    <div id="compraservicio">
        <section class="section">
            <div class="section-body">
                @if ($data->isNotEmpty())
                    <input type="text" id="inputServicioId" value="{{$serviceId}}" hidden>
                    @foreach ($data as $key => $p)

                        <div class="invoice">
                            <div class="invoice-print">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="invoice-title">
                                            <h2>{{ $p->nombre }}</h2>
                                            <div class="invoice-number"></div>
                                        </div>
                                        <hr>
                                        <div class="alert alert-success text-left" role="alert" id="alertaGuardado" style="display:none;">
                                            <h5 class="alert-heading"><i class="fas fa-check-circle font-15"></i>&nbsp;
                                                ¡Plan obtenido de forma exitosa!
                                            </h5>
                                            <h5>
                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                Un asesor se contactar&aacute; con usted para activar el plan obtenido.
                                            </h5>
                                            <div class="fa-2x">
                                                <h6><i class="fas fa-sync fa-spin font-15"></i>&nbsp;&nbsp;Redirigiendo...</h6>
                                            </div>
                                        </div>
                                        <div class="alert alert-info text-left" role="alert" id="alertaPago" style="display:none;">
                                            <h5 class="alert-heading"><i class="fas fa-check-circle font-15"></i>&nbsp;
                                                ¡Pago realizado de forma exitosa!
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <address style="text-align: justify;">
                                                    <p>
                                                        {!!htmlspecialchars_decode($p->descripcion)!!}
                                                    </p>
                                                </address>
                                                <h5>En este servicio encontrará lo siguiente: </h5>
                                                @foreach ($subservicios as $key => $sub)
                                                    <div class="info-box mb-3 bg-primary">
                                                        <span class="info-box-icon">{{ $key + 1 }}</span>
                                                        <div class="info-box-content">
                                                        <span class="info-box-text">{{ $sub->nombre }}</span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="col-md-6 text-md-right">

                                                <div class="card">
                                                    <div class="card-header">
                                                        <h3>Planes Disponibles</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                                            <li class="nav-item" v-for="(tipo, index) in tipoplans" :key="tipo.id">
                                                                <a class="nav-link " ref="index" :class="index == 0 ? 'active' : '' "  id="home-tab2"
                                                                    data-toggle="tab" href="#home" role="tab"
                                                                    aria-controls="home"
                                                                    aria-selected="true" @click="mostrardetalle(tipo)" ><b>@{{ tipo . nombre }}</b>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                        <div class="tab-content" id="myTab3Content">
                                                            <div class="tab-pane fade show active"  id="home" role="tabpanel" aria-labelledby="home-tab2">
                                                                <p><span align="left" v-html="detalle.descripcion"></span></p>
                                                                <br>
                                                                <span class="text-center center-align"><h2><strong >$@{{detalle.costo}}</strong></h2>
                                                                <h6 style="font-weight: 200;"><span class="badge badge-light">Duraci&oacute;n:&nbsp;@{{detalle.cantidad_meses}} mes(es)</span><h6>
                                                                </span>
                                                                <span id="precioPlan" hidden>@{{detalle.costo}}</span>
                                                                <br>
                                                                @if(!$empresas->isEmpty() && $empresas->count() > 1)
                                                                    <div class="alert alert-primary text-left" role="alert">
                                                                        <h6 class="alert-heading"><i class="fas fa-exclamation-circle font-15"></i>&nbsp;
                                                                            Usted cuenta con <b>{{$empresas->count()}} empresas añadidas</b>, por favor escoger la empresa para proceder con la compra.
                                                                        </h6>
                                                                    </div>
                                                                <br>
                                                                @endif
                                                                    <input id="contadorEmpresas" value="{{$empresas->count()}}" hidden>
                                                                    <div class="alert alert-danger text-left" role="alert" id="alertaDuplicado" style="display:none;">
                                                                        <h6 class="alert-heading"><i class="fas fa-exclamation-triangle font-15"></i>&nbsp;
                                                                            Usted ya realiz&oacute; la compra de este plan para la empresa <b><u><span id="textoDuplicado"></span></u></b>.
                                                                            <br><br>
                                                                            Por favor elija otra empresa y otro plan o comun&iacute;quese con uno de nuestros asesores.
                                                                        </h6>
                                                                    </div>
                                                                    @if(!$empresas->isEmpty())

                                                                        @if($empresas->count() > 1)
                                                                        <div class="row justify-content-center align-self-center">
                                                                            <label class="align-bottom"> <b>Empresas Añadidas:&nbsp;</b></label>
                                                                            <select class="form-select" id="selectEmpresa" @change="selectEmpresa(this)">
                                                                            <option value="">Seleccionar Empresa</option>
                                                                            @foreach ($empresas as $keyEmpresa => $e)
                                                                                <option value="{{$e->id}}">{{$e->razon_social}}</option>
                                                                            @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <br>
                                                                        @endif

                                                                        @if($empresas->count() == 1)
                                                                        <div class="row justify-content-center align-self-center" hidden>
                                                                            <label class="align-bottom"> <b>Empresas Añadidas:&nbsp;</b></label>
                                                                            <select class="form-select" id="selectEmpresa" @change="selectEmpresa(this)">
                                                                            <option value="0" selected>Seleccionar Empresa</option>
                                                                            </select>
                                                                        </div>
                                                                        <br>
                                                                        @endif
                                                                        <div class="row justify-content-center align-self-center">
                                                                            <small class="text-danger"><i class="fas fa-exclamation"></i>&nbsp;Leer y aceptar los t&eacute;rminos y condiciones para realizar la compra</small>
                                                                        </div>
                                                                        <br>
                                                                        <div class="text-md-right">
                                                                            <div class="float-lg-left mb-lg-0 mb-3">
                                                                                <button class="btn btn-primary btn-icon icon-left"
                                                                                data-toggle="modal" data-target=".bd-example-modal-lg">
                                                                                <h6><i class="fas fa-file-alt font-15"></i>&nbsp;Leer términos y condiciones</h6></button>
                                                                                <input type="text" id="boolAceptado" value="N" hidden>
                                                                                <button class="btn btn-light btn-icon icon-left" id="btnCompra" :disabled="buttonDisable"
                                                                                @click.prevent="compraBoton()">
                                                                                <h6><i class="fas fa-shopping-cart"></i>&nbsp;Comprar Plan</h6></button>
                                                                                <br><br>

                                                                                <div class="row justify-content-center align-self-center" id="metodoPagoDiv" style="display: none;">
                                                                                    <label class="align-bottom"> <b>M&eacute;todos de Pago:&nbsp;&nbsp;</b></label>
                                                                                    <select class="form-select" id="metodoPago"  @change="selectMetodoPago(this)" style="vertical-align: top;">
                                                                                        <option value="0" selected>Seleccionar M&eacute;todo de Pago</option>
                                                                                        <option value="T">Transferencia Bancaria</option>
                                                                                        <option value="B">Bot&oacute;n de Pago (via Payphone)</option>
                                                                                    </select>
                                                                                </div>

                                                                                <button type="button" class="btn btn-success" id="confirmarCompraTransferencia" @click="confirmarCompraTransferencia()" hidden></button>

                                                                                <div id="pp-button" style="display:none;"></div>
                                                                            </div>
                                                                        </div>
                                                                        {{--<button type="button" class="btn btn-primary" >Large modal</button>--}}


                                                                    @else
                                                                    <div class="alert alert-danger text-left" role="alert">
                                                                        <h6 class="alert-heading"><i class="fas fa-exclamation-triangle font-15"></i>&nbsp;No tiene empresas asignadas.
                                                                        <br>
                                                                        Para asignar empresas <a href="{{route('admin.mis.empresas', $p->slug )}}" class="alert-link">IR AL SIGUIENTE LINK.</a></h6>
                                                                    </div>
                                                                    @endif
                                                                    <br>
                                                                    {{-- <button class="btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i> Print</button> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-md-right">
                                    <div class="float-lg-left mb-lg-0 mb-3">
                                        <a type="button" class="btn btn-outline-success btn-icon icon-left" href="https://wa.me/+593968855682?text=Hola, Estoy interesado en obtener sus servicios."  target="_blank" >
                                            <i class="fab fa-whatsapp font-15"></i>&nbsp;¿Dudas? Cont&aacute;ctanos y te atenderemos personalmente
                                        </a>
                                    </div>
                                </div>
                                <hr>
                                <div class="text-md-right">
                                    <div class="float-lg-left mb-lg-0 mb-3">
                                        <a type="button" class="btn btn-danger btn-icon icon-left" href="{{route('tienda.index', $serviceId) }}" >
                                            <i class="fas fa-times font-15"></i>&nbsp;Cancelar
                                        </a>
                                    </div>
                                    <br>
                                    {{-- <button class="btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i> Print</button> --}}
                                </div>
                            </div>

                        </div>
                    @endforeach
                @endif
            </div>
        </section>

    </div>
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">T&eacute;rminos y Condiciones</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="cerrarModalTC">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                    El presente contrato describe los términos y condiciones aplicables al uso del contenido, productos y/o servicios del sitio web Mil Formatos del cual es titular Rubén Pérez Pérez. Para hacer uso del contenido, productos y/o servicios del sitio web el usuario deberá sujetarse a los presentes términos y condiciones.
                    </p>
                    <h6><b>I. OBJETO</b></h6>
                    <p>
                    El objeto es regular el acceso y utilización del contenido, productos y/o servicios a disposición del público en general en el dominio https://www.milformatos.com.

                    El titular se reserva el derecho de realizar cualquier tipo de modificación en el sitio web en cualquier momento y sin previo aviso, el usuario acepta dichas modificaciones.

                    El acceso al sitio web por parte del usuario es libre y gratuito, la utilización del contenido, productos y/o servicios implica un costo de suscripción para el usuario.

                    El sitio web solo admite el acceso a personas mayores de edad y no se hace responsable por el incumplimiento de esto.

                    El sitio web está dirigido a usuarios residentes en México y cumple con la legislación establecida en dicho país, si el usuario reside en otro país y decide acceder al sitio web lo hará bajo su responsabilidad.

                    La administración del sitio web puede ejercerse por terceros, es decir, personas distintas al titular, sin afectar esto los presentes términos y condiciones.
                    </p>
                    <h6><b>II. USUARIO</b></h6>
                    <p>
                    La actividad del usuario en el sitio web como publicaciones o comentarios estarán sujetos a los presentes términos y condiciones. El usuario se compromete a utilizar el contenido, productos y/o servicios de forma lícita, sin faltar a la moral o al orden público, absteniéndose de realizar cualquier acto que afecte los derechos de terceros o el funcionamiento del sitio web.

                    El usuario se compromete a proporcionar información verídica en los formularios del sitio web.

                    El acceso al sitio web no supone una relación entre el usuario y el titular del sitio web.

                    El usuario manifiesta ser mayor de edad y contar con la capacidad jurídica de acatar los presentes términos y condiciones.
                    </p>
                    <h6><b>III. ACCESO Y NAVEGACIÓN EN EL SITIO WEB</b></h6>
                    <p>
                    El titular no garantiza la continuidad y disponibilidad del contenido, productos y/o servicios en el sitito web, realizará acciones que fomenten el buen funcionamiento de dicho sitio web sin responsabilidad alguna.

                    El titular no se responsabiliza de que el software esté libre de errores que puedan causar un daño al software y/o hardware del equipo del cual el usuario accede al sitio web. De igual forma, no se responsabiliza por los daños causados por el acceso y/o utilización del sitio web.
                    </p>
                </div>
                <div class="modal-footer bg-primary" style="padding-left: 5px !important; padding-right: 5px !important;">
                    <div class="col-lg-7 input-group text-left">
                        <input type="checkbox" id="checkAcepto" value="" style="margin-top: revert;" onclick="checkAcepto()">
                        <label class="form-check-label text-white" for="inlineCheckbox1"><b>&nbsp;&nbsp;He le&iacute;do y acepto los t&eacute;rminos y condiciones de uso.</b></label>
                    </div>
                    <div class="col-lg-5 input-group">
                        <button type="button" class="btn btn-success" data-dismiss="modal" style="display: none;" id="alertaCheck">
                            <b class="medium-font-size">Cerrar esta ventana para continuar con la compra</b>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="bancosModalLabel" id="bancosModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title text-white" id="bancosModalLabel">Bancos Disponibles</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="alert text-left amarillo-banco" role="alert" >
                                <div class="row">
                                    <div class="col-sm-6">
                                        <img class="nav_logo_img img-fluid top-left" src="/images/icons/Banco_Pichincha.png" style="width: 75%;">
                                    </div>
                                    <div class="col-sm-6 text-left text-dark">
                                        <span style="white-space: pre-line"><b>Beneficiario:</b> Nombre beneficiario
                                        <b>Tipo de Cuenta:</b> Cuenta de Ahorros
                                        <b>No. de Cuenta:</b> 123456789
                                        <b>No. de C&eacute;dula:</b> 0987654321
                                        <b>Correo Electrónico:</b> cobros@pruebamail.com
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="alert text-left rosa-banco" role="alert">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <img class="nav_logo_img img-fluid top-left" src="/images/icons/Banco_Guayaquil.png" style="width: 75%;">
                                    </div>
                                    <div class="col-sm-6 text-left text-dark">
                                        <span style="white-space: pre-line"><b>Beneficiario:</b> Nombre beneficiario
                                        <b>Tipo de Cuenta:</b> Cuenta de Ahorros
                                        <b>No. de Cuenta:</b> 123456789
                                        <b>No. de C&eacute;dula:</b> 0987654321
                                        <b>Correo Electrónico:</b> cobros@pruebamail.com
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="alert text-left alert-light" role="alert">
                                <label for="formFile" class="form-label" style="display: flex">
                                    <i class="fa fa-exclamation-circle" aria-hidden="true" style="font-size: 25px"></i>
                                    &nbsp;<h5>Una vez realizado el pago, subir la imagen del comprobante</h5>
                                </label>
                                <label class="text-danger" style="display: none" id="comprobantePagoLabel">
                                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>&nbsp;<b>Ingresar comprobante de pago</b>
                                </label>
                                <input class="form-control" type="file" id="comprobantePago">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="clickCierra()"><h6>Cerrar</h6></button>
                            <button type="button" class="btn btn-success" onclick="clickConfirma()"><h6>Confirmar Compra</h6></button>
                        </div>
                    </div>
                </div>
            </div>

@endsection


@section('js')

    <script type="text/javascript">
    function checkAcepto() {
        var checkBox = document.getElementById("checkAcepto");

        if (checkBox.checked == true){
            document.getElementById('boolAceptado').value = "S";
            document.getElementById('btnCompra').disabled = false;
            document.getElementById("btnCompra").classList.remove("btn-light");
            document.getElementById("btnCompra").classList.add("btn-success");
            document.getElementById("alertaCheck").style.display = "block";
            //document.getElementById('pago').disabled = false;
            //document.getElementById('cerrarModalTC').click();
        } else {
            document.getElementById('boolAceptado').value = "N";
            document.getElementById('btnCompra').disabled = true;
            document.getElementById("btnCompra").classList.remove("btn-success");
            document.getElementById("btnCompra").classList.add("btn-light");
            document.getElementById("alertaCheck").style.display = "none";
            //document.getElementById('pago').disabled = true;
        }
    }

    function clickCierra() {
        let selectPago = document.getElementById('metodoPago');
        let comprobante = document.getElementById("comprobantePago");

        if(selectPago.value !== 0){
            selectPago.value = 0;
        }

        comprobante.value = null;
    }

    function clickConfirma(){
        var confirmaBoton = document.getElementById("confirmarCompraTransferencia");
        confirmaBoton.click();
    }

         class Errors {
            constructor() {
                this.errors = {}
            }
            has(field) {
                return this.errors.hasOwnProperty(field);
            }
            get(field) {
                if (this.errors[field]) {
                    return this.errors[field][0]
                }
            }
            record(errors) {
                this.errors = errors;
            }
            any() {
                return Object.keys(this.errors).length > 0;
            }
            anyfiles(query) {
                const asArray = Object.entries(this.errors);
                //const atLeast9Wins = asArray.filter(([key, value]) => key !== 'fecha_atencion' && key !== 'responsable_id' && key !== 'detalle_atencion' && key !== 'observacion' );
                const atLeast9Wins = asArray.filter(([key, value]) => key.toLowerCase().indexOf(query.toLowerCase()) > -
                    1);
                const atLeast9WinsObject = Object.fromEntries(atLeast9Wins);

                return Object.keys(atLeast9WinsObject).length > 0;
            }
            archivos(query) {
                const asArray = Object.entries(this.errors);
                //const atLeast9Wins = asArray.filter(([key, value]) => key !== 'fecha_atencion' && key !== 'responsable_id' && key !== 'detalle_atencion' && key !== 'observacion' );
                const atLeast9Wins = asArray.filter(([key, value]) => key.toLowerCase().indexOf(query.toLowerCase()) > -
                    1);
                const atLeast9WinsObject = Object.fromEntries(atLeast9Wins);
                return atLeast9WinsObject;
            }

        }

        let plans = @json($tipoplan);
        const compraservicio = new Vue({
            el: "#compraservicio",
            name: "Compra Servicios",
            data: {
                tipoplans: plans,
               
                buttonDisable: true,
                plans: [],
                detalle:{
                    costo:'',
                    descripcion:'',
                    service_id:'',
                    errors: new Errors,
                    tipoplan_id: '',
                    plan_id:'',

                },
            },

            mounted() {
                let empresas = document.getElementById("contadorEmpresas");
                if(empresas.value > 1)
                    this.buttonDisable = true;

                var tp = this.tipoplans;

                this.tipoplans.forEach((element ,index, array) => {
                    //console.log(element);
                    if (index == 0) {
                        this.detalle.costo = element.costo;
                        this.detalle.descripcion = element.descripcion;
                        this.detalle.service_id = element.service_id;
                        this.detalle.tipoplan_id = element.tipoplan_id;
                        this.detalle.plan_id = element.id;
                        this.detalle.cantidad_meses = element.cantidad_meses;
                    }
                });
            },

            methods: {
                selectEmpresa(element) {
                    if(element.value !== ''){
                        //this.buttonDisable = false;
                    }else{
                        this.buttonDisable = true;
                    }
                },

                selectMetodoPago(element) {
                    //this.buttonDisable = true;
                    let metodo = document.getElementById("metodoPago").value;

                    if(metodo == "T"){
                        $('#bancosModal').modal('show');
                        //document.getElementById("pp-button").style.display = "none";
                    }else if(metodo == "B"){
                        document.getElementById("pp-button").style.display = "block";

                        this.validaciones('pendiente');
                    }

                    //this.validaciones('pendiente');
                },

                confirmarCompraTransferencia(letra){

                    let metodo = document.getElementById("metodoPago").value;
                    let comprobante = document.getElementById("comprobantePago");

                    if(metodo == "T" && comprobante.files.length == 0 ){
                        document.getElementById("comprobantePagoLabel").style.display = "block";
                    }else{
                        $('#bancosModal').modal('hide')
                        this.validaciones('pendiente');
                    }

                    //$('#bancosModal').modal('hide')
                    //this.validaciones('pendiente');
                },

                compraBoton(){
                    document.getElementById("metodoPagoDiv").style.display = "block";
                },
            
                mostrardetalle(tipo){
                  
                    this.detalle.costo = tipo.costo;
                    this.detalle.descripcion = tipo.descripcion;
                    this.detalle.service_id = tipo.service_id;
                    this.detalle.tipoplan_id = tipo.tipoplan_id;
                    this.detalle.cantidad_meses = tipo.cantidad_meses;
                    this.detalle.plan_id = tipo.id;

                    let selectEmpresa = document.getElementById('selectEmpresa');
                    /*console.log(selectEmpresa.value);
                    if(document.getElementById('selectEmpresa')){
                        console.log("**si existe**");
                    }else{
                        console.log("**no existe**");
                    }*/

                    if(selectEmpresa.value == 0){
                        selectEmpresa.value = 0;
                    }else if(selectEmpresa.value !== "" ){
                        selectEmpresa.value = "";
                    }

                    var checkBox = document.getElementById("checkAcepto");

                    if(checkBox.checked == true){
                        checkBox.checked = false;
                        document.getElementById('boolAceptado').value = "N";
                        document.getElementById('btnCompra').disabled = true;
                        document.getElementById("btnCompra").classList.remove("btn-success");
                        document.getElementById("btnCompra").classList.add("btn-light");
                        document.getElementById("alertaCheck").style.display = "none";
                    }

                    let selectPago = document.getElementById('metodoPago');

                    if(selectPago.value !== 0){
                        selectPago.value = 0;
                    }

                    document.getElementById("metodoPagoDiv").style.display = "none";
                    document.querySelectorAll(".payphone").forEach(el => el.remove());

                    console.log(this.detalle);
                }, //end mostrardetalle

                generarCodigo(length) {
                    var result           = '';
                    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                    var charactersLength = characters.length;
                    for ( var i = 0; i < length; i++ ) {
                        result += characters.charAt(Math.floor(Math.random() * charactersLength));
                    }
                    return result;
                },

                validaciones(estado){

                    let empresa = document.getElementById('selectEmpresa').selectedOptions[0].value;

                    let set = this;

                    let dataValida = new FormData();
                    dataValida.append('service_id', this.detalle.service_id);
                    dataValida.append('tipoplan_id', this.detalle.tipoplan_id);
                    dataValida.append('plan_id', this.detalle.plan_id);
                    dataValida.append('empresa', empresa);

                    let data ={ data: dataValida };
                    let flagValida = false;

                    axios.post('/tienda/consultaEmpresa', data.data)
                    .then(function(res){
                        flagValida = res.data.flag;

                        if(flagValida == true){
                            document.getElementById("textoDuplicado").textContent = res.data.empresa;
                            let elementoOculta = document.getElementById("alertaDuplicado");
                            elementoOculta.style.display = "block";
                            set.buttonDisable = true;
                        }else{
                            //let elementoOculta = document.getElementById("pp-button");
                            //elementoOculta.style.display = "block";

                            let datos = set.createData(estado, empresa);
                            return set.StoreData(datos);
                        }
                    });
                        /*.catch(function(error) {
                            if (error.response.status == 422) {
                                set.errors.record(error.response.data.errors);
                            }
                            set.buttonDisable = false;
                        });*/

                    /*if(flagValida == true){
                        console.log("*** FLAG TRUE***");
                        document.getElementById("textoDuplicado").textContent = res.data.empresa;
                        let elementoOculta = document.getElementById("alertaDuplicado");
                        elementoOculta.style.display = "block";
                        this.buttonDisable = true;
                    }else{
                        //let elementoOculta = document.getElementById("pp-button");
                        //elementoOculta.style.display = "block";
                        let datos = this.createData(estado, empresa);
                        return this.StoreData(datos);
                    }*/

                    //let datos = this.createData(estado, empresa);
                    //return this.StoreData(datos);
                }, //end validacion

                createData(estado, empresa){
                    let set = this;
                    let url = '/tienda/storeplan';
                    let countPay = document.querySelectorAll('.payphone').length;
                    let metodo = document.getElementById("metodoPago").value;
                    let comprobante = null;

                    if(metodo == "T"){
                        comprobante = document.getElementById("comprobantePago").files[0];
                    }

                    if (countPay > 0)
                        document.querySelector(".payphone").remove();

                    var data = new FormData();
                    data.append('service_id', this.detalle.service_id);
                    data.append('tipoplan_id', this.detalle.tipoplan_id);
                    data.append('costo', this.detalle.costo);
                    data.append('plan_id', this.detalle.plan_id);
                    data.append('estado', estado);
                    data.append('empresa', empresa);
                    data.append('tipoPago', metodo);

                    if(metodo == "T"){
                        data.append('comprobante', comprobante);
                    }

                    var datos ={
                        url: url,
                        amount: this.detalle.costo * 100,
                        cantidad_mes: this.detalle.cantidad_meses,
                        data: data
                    };

                    return datos;

                }, //createdata End

                StoreData(data){
                    var set = this;
                    var codigoTransaccion = this.generarCodigo(10);
                    let metodo = document.getElementById("metodoPago").value;

                    if(metodo == "T"){
                        axios.post(data.url, data.data)
                        .then(function(res){
                            this.buttonDisable = true;
                            document.getElementById('alertaGuardado').style.display = 'block';
                            var idServicio = document.getElementById("inputServicioId").value;

                            setTimeout(function () {
                                ////window.location.href = window.location.href;
                                let link = "{{ route('home')}}";
                                window.location = link;
                            }, 2500);


                        })
                        .catch(function(error) {
                            if (error.response.status == 422) {
                                set.errors.record(error.response.data.errors);
                            }
                            set.buttonDisable = false;
                        });
                    }else if(metodo == "B"){
                        payphone.Button({

                        //token obtenido desde la consola de developer
                        token: "wYUrSjbo5dQts9Jw6xUqtKZu8KImxuhiKb4qpGXE87NiCGdatWQ-EM7Y9Z86Ad7a_SelhV_ScxTks_JCJMJtZ6_lK8hqjr3xVG_0yZ4sx7SPfmzUpnexSXs4Vgeq1qFa1xJkEjztTzctTRlwB-7OujyJtvMgEVW4bGeFewklAcmeouXNO4XLrdNaHKwheMob57N8ua0P0Irg90Ft1hUvu63Pwq1yHIfTU3eEbm511MLpyXiXLtzCNzEuf1ehbgH2y6EtYdawDHSts37WADDeAZxaBFA5q2eYy0rL0CVBJIb6oazotkt5gOrR4ZxvdT40He6TDw",

                        //PARÁMETROS DE CONFIGURACIÓN
                        btnHorizontal: true,
                        btnCard: true,

                        createOrder: function(actions){

                        //Se ingresan los datos de la transaccion ej. monto, impuestos, etc

                            return actions.prepare({
                                amount: (data.amount * data.cantidad_mes),
                                amountWithoutTax: (data.amount * data.cantidad_mes),
                                currency: "USD",
                                clientTransactionId: codigoTransaccion
                            });

                        },
                        onComplete: function(model, actions){

                            //Se confirma el pago realizado
                            actions.confirm({
                            id: model.id,
                            clientTxId: model.clientTxId
                            }).then(function(value){

                                //EN ESTA SECCIÓN SE RECIBE LA RESPUESTA Y SE MUESTRA AL USUARIO
                                console.log(value.transactionStatus);
                                if (value.transactionStatus == "Approved"){
                                    //alert("Pago " + value.transactionId + " recibido, estado " + value.transactionStatus );
                                    let urlAprobar = "/tienda/respuestaPago/"+value.transactionId+"/"+value.clientTransactionId;

                                    axios.get(urlAprobar)
                                    .then(function(respuesta){
                                        console.log("respuesta");
                                        //this.buttonDisable = true;
                                        //document.getElementById('alertaGuardado').style.display = 'block';
                                        //document.getElementsByClassName("payphone").remove();


                                        if(respuesta.data == 1){
                                            //var url ='/tienda/storeplan';

                                            document.getElementById('alertaPago').style.display = 'block';
                                            data.data.append('transactionId', value.transactionId);
                                            data.data.append('clientTransactionId', value.clientTransactionId);

                                            axios.post(data.url, data.data)
                                            .then(function(res){
                                                console.log("guarda");
                                                this.buttonDisable = true;
                                                document.getElementById('alertaGuardado').style.display = 'block';
                                                //document.getElementsByClassName("payphone").remove();
                                                document.querySelectorAll(".payphone").forEach(el => el.remove());
                                                document.getElementById("metodoPagoDiv").style.display = "none";
                                                var idServicio = document.getElementById("inputServicioId").value;

                                                setTimeout(function () {
                                                    ////window.location.href = window.location.href;
                                                    let link = "{{ route('home')}}";
                                                    window.location = link;
                                                }, 2500);

                                            })
                                            .catch(function(error) {
                                                console.log(error);
                                                if (error.response.status == 422) {
                                                    set.errors.record(error.response.data.errors);
                                                }
                                                set.buttonDisable = false;
                                            });

                                        }
                                    })
                                    .catch(function(error) {
                                        console.log(error);
                                        if (error.response.status == 422) {
                                            set.errors.record(error.response.data.errors);
                                        }
                                        set.buttonDisable = false;
                                    });
                                }
                            })
                        .catch(function(err){
                            console.log(err);
                        });

                        }
                        }).render("#pp-button");
                    }



                    /*axios.post(data.url, data.data)
                    .then(function(res){
                        this.buttonDisable = true;
                        document.getElementById('alertaGuardado').style.display = 'block';
                        //document.getElementsByClassName("payphone").remove();

                        //setTimeout(function () {
                            ////window.location.href = window.location.href;
                        //    let link = '';
                        //    window.location = link;
                        //}, 2500);

                        //let link = '';
                        //window.location = link;
                    })
                    .catch(function(error) {
                        if (error.response.status == 422) {
                            set.errors.record(error.response.data.errors);
                        }
                        set.buttonDisable = false;
                    });*/

                }, //end storedata
                
            },

        });




        window.onload = function() {
            

        }
    </script>




@endsection
