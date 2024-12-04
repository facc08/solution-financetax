<template>
<div>
    <button @click="modalNuevoRegistro = true,resetForm()" class="btn btn-primary btn-sm mb-2" style="width: fit-content;"><i class="fa fa-plus"></i>&nbsp;Nuevo Registro</button>
    <div class="card">
        <div class="card-body">
            <div class="col-lg-12 col-md-10">
                <div class="row">
                    <div class="col-lg-6 justify-content-left">
                    <button class="floated btn btn-success btn-sm" @click="mostrarElementos('tblTransacciones_wrapper')">
                        Detalle &nbsp;<i class="fas fa-table"></i>
                    </button>
                    &nbsp;&nbsp;
                    <button class="floated btn btn-success btn-sm" id="btnGraficos" @click="mostrarElementos('divGraficos')">
                        Gr&aacute;ficos &nbsp;<i class="fas fa-chart-bar"></i>
                    </button>
                    </div>

                    <div class="col-lg-6 text-right">
                        <a type="button" class="btn btn-success" :href="'/admin/exportarDocumentos/'+this.servicioUsuario" id="btnExportar"><i class="far fa-file-excel font-15"></i>&nbsp;Exportar a Excel</a>
                    </div>
                </div></br>
                <div class="row justify-content-center">
                    <div class="form-group col-6 col-md-3">
                        <label><b>Filtrar por Fecha: </b></label>
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control form-control-sm inputDateRange">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-info resetDateFilter" @click="resetDate" type="button">
                                    <i class="fa fa-retweet"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="tblTransacciones" class="table table-striped table-bordered table-sm" style="width:100%;">
                    <thead style="font-size:9.0pt;">
                        <tr>
                            <th class="text-center" style="width:100px;">Fecha de emisi&oacute;n</th>
                            <th style="width:150px;">Tipo Transacci&oacute;n</th>
                            <th class="text-center">Categor&iacute;a </th>
                            <th class="text-center">Detalle</th>
                            <th class="text-center" style="width:60px;">IVA</th>
                            <th class="text-center" style="width:60px;">Importe</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in transacciones" :key="item.id">
                            <td class="text-center">{{ item.fecha }}</td>
                            <td class="text-center">
                                <span class="badge badge-primary">{{ item.tipo }}</span>
                            </td>
                            <td>{{ item.categoria }}</td>
                            <td>{{ item.detalle }}</td>
                            <td class="text-right pr-4">${{ item.iva }}</td>
                            <td class="text-right pr-4">${{ item.importe }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row justify-content-center" id="divGraficos" style="display:none;">
            <div class="col-10">
                <highcharts :options="chartOptions"></highcharts>
            </div>
            </br>
            </br>
            <div class="col-10">
                <highcharts :options="chartOptionsPie"></highcharts>
            </div>
        </div>

        <!-- Modal Nuevo Registro -->
        <div class="modal" :class="{mostrar:modalNuevoRegistro}">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Registrar Comprobante</h4>
                        <button @click="cerrarModal()" type="button" class="close" >&times;</button>
                    </div>
                    <!-- Modal body -->
                    <form @submit.prevent="storeService" enctype="multipart/form-data" ref="form">
                    <div class="modal-body">
                        <div class="form-group row mb-2">
                            <label for="fecha" class="col-4 col-form-label"><b>Fecha Documento</b></label>
                            <div class="col-8">
                                <input v-model="comprobante.fecha" type="date" class="form-control" id="fecha">
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="tipo" class="col-4 col-form-label"><b>Tipo de Transacción</b></label>
                            <div class="col-8">
                                <select v-model="comprobante.tipo_transaccion" @change="validaTipoTransaccion($event)" class="form-control" id="tipo">
                                    <option value="">Seleccionar</option>
                                    <option v-for="item in tipoTransaccion" :key="item.id" :value="item.id" v-text="item.nombre"></option>
                                </select>
                                <span class="text-danger campo-obligatorio d-none">Campo Obligatorio</span>
                            </div>
                        </div>
                        <!--div class="form-group row mb-2">
                            <label for="tipo" class="col-4 col-form-label"><b>Categor&iacute;a</b></label>
                            <div class="col-8">
                                <select v-model="comprobante.tipo_categoria" class="form-control" id="categoria">
                                    <option value="">Seleccionar</option>
                                    <option v-for="item in categoria" :key="item.id" :value="item.id" v-text="item.descripcionCodigo"></option>
                                </select>
                                <span class="text-danger campo-obligatorio d-none">Campo Obligatorio</span>
                            </div>
                        </div-->
                        <div class="form-group row mb-2">
                            <label for="tipo" class="col-4 col-form-label"><b>Formas de {{formasCobroPago}}</b></label>
                            <div class="col-8">
                                <select v-model="comprobante.formas_cobro" class="form-control" id="formasCobro">
                                    <option value="">Seleccionar</option>
                                    <option v-for="item in formasCobro" :key="item.id" :value="item.id" v-text="item.descripcion"></option>
                                </select>
                                <span class="text-danger campo-obligatorio d-none">Campo Obligatorio</span>
                            </div>
                        </div>
                        <div class="form-group row mb-2" v-if=mostrarSustento>
                            <label for="tipo" class="col-4 col-form-label"><b>Sustento Tributario</b></label>
                            <div class="col-8">
                                <select v-model="comprobante.sustentoTributario" class="form-control" id="sustento">
                                    <option value="">Seleccionar</option>
                                    <option v-for="item in sustento" :key="item.id" :value="item.id" v-text="item.descripcionSustento"></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-2" v-if=mostrarTipoComprobante>
                            <label for="tipo" class="col-4 col-form-label"><b>Tipo Comprobante</b></label>
                            <div class="col-8">
                                <select v-model="comprobante.tipoComprobante" class="form-control" id="tipoComprobante">
                                    <option value="">Seleccionar</option>
                                    <option v-for="item in tipoComprobante" :key="item.id" :value="item.id" v-text="item.descripcionTipoComprobante"></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="tipo" class="col-4 col-form-label"><b>Retenci&oacute;n en la fuente del IVA</b></label>
                            <div class="col-8">
                                <select v-model="comprobante.retencion_fuente_iva" class="form-control" @change="seleccionaRFI">
                                    <option value="">Seleccionar</option>
                                    <option v-for="item in retencionFuenteIva" :key="item.id" :value="item.id" v-text="item.descripcionRetencionIva">
                                    </option>
                                </select>
                                <span class="text-danger campo-obligatorio d-none">Campo Obligatorio</span>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="tipo" class="col-4 col-form-label"><b>Retenci&oacute;n impuesto a la renta</b></label>
                            <div class="col-8">
                                <select v-model="comprobante.retencion_impuesto_renta" class="form-control" @change="seleccionaRIR">
                                    <option value="">Seleccionar</option>
                                    <option v-for="item in retencionImpuestoRenta" :key="item.id" :value="item.id"
                                            v-text="item.descripcionRetencionImpuestoRenta">
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="porcentajeImpuestoRenta" class="col-4 col-form-label"><b>Porcentaje Retenci&oacute;n impuesto a la renta</b></label>
                            <div class="col-8 input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm"><small>%</small></span>
                                </div>
                                <input v-model="comprobante.porcentajeRetencionImpuestoRenta" :disabled="disablePorcentajeRIR" type="text" class="form-control" id="porcentajeRIR">
                            </div>
                        </div>
                        <div class="form-group row mb-2" id="divCuenta" v-show="flagPermiso">
                            <label for="cuenta" class="col-4 col-form-label"><b>Cuenta</b></label>
                            <div class="col-8">
                                <select v-model="comprobante.cuenta" class="form-control" id="cuenta">
                                    <option value="">Seleccionar</option>
                                    <option v-for="item in cuentas" :key="item.id" :value="item.id" v-text="item.cuenta"></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="tarifacero" class="col-4 col-form-label"><b>Tarifa 0%</b></label>
                            <div class="col-8 input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm"><small>$</small></span>
                                </div>
                                <money v-model="comprobante.tarifacero" class="form-control text-right" id="tarifacero"></money>
                            </div>
                            <div class="col-8 text-right">
                                <span class="text-danger campo-obligatorio d-none">Campo Obligatorio</span>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="tarifadifcero" class="col-4 col-form-label"><b>Tarifa Dif. de 0%</b></label>
                            <div class="col-8 input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm"><small>$</small></span>
                                </div>
                                 <money v-model="comprobante.tarifadifcero" class="form-control text-right" id="tarifadifcero"></money>
                            </div>
                            <div class="col-8 text-right">
                                <span class="text-danger campo-obligatorio d-none">Campo Obligatorio</span>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="iva" class="col-4 col-form-label"><b>IVA</b></label>
                            <div class="col-8 input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm"><small>$</small></span>
                                </div>
                                 <money v-model="comprobante.iva" class="form-control text-right" id="iva"></money>
                            </div>
                            <div class="col-8 text-right">
                                <span class="text-danger campo-obligatorio d-none">Campo Obligatorio</span>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="iva" class="col-4 col-form-label"><b>IVA % Porcentaje</b></label>
                            <div class="col-8 input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm"><small>%</small></span>
                                </div>
                                 <money v-model="comprobante.ivaPorcentaje" class="form-control text-right" id="ivaPorcentaje"></money>
                            </div>
                            <div class="col-8 text-right">
                                <span class="text-danger campo-obligatorio d-none">Campo Obligatorio</span>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="importe" class="col-4 col-form-label"><b>Importe</b></label>
                            <div class="col-8 input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm"><small>$</small></span>
                                </div>
                                 <money v-model="comprobante.importe" class="form-control text-right" id="importe"></money>
                            </div>
                            <div class="col-8 text-right">
                                <span class="text-danger campo-obligatorio d-none">Campo Obligatorio</span>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="detalle" class="col-4 col-form-label"><b>Detalle</b></label>
                            <div class="col-8">
                                <input v-model="comprobante.detalle" type="text" class="form-control" id="detalle">
                                <span class="text-danger campo-obligatorio d-none">Campo Obligatorio</span>
                            </div>
                        </div>
                        <hr>
                        <div id="contenedorCamposImagen">
                            <span id="camposImagen">
                            </span>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="nota" class="col-4 col-form-label"><b>Imagen Documento</b></label>
                            <div class="col-8 text-right">
                                <a href="#" @click="abrirInputFile">
                                    <i class="fa fa-camera fa-2x" aria-hidden="true" id="fileIcon"></i>
                                </a>
                                <input type="file" @change="obtenerImagen" class="form-control form-control-sm d-none" id="inputFile" accept="image/*">
                                <span class="text-danger campo-obligatorio d-none">Campo Obligatorio</span>
                            </div>
                        </div>
                        <div class="alert alert-danger text-left" role="alert" id="alertaTipoImagen" style="margin: 10px; display:none;">
                            <h6 class="alert-heading"><i class="fas fa-exclamation-triangle" style="font-size: 15px;"></i>&nbsp;
                                Tipo de archivo no permitido. Los formatos permitidos son <b>.JPG</b> o <b>.PNG</b>
                            </h6>
                        </div>
                        <div class="alert alert-info text-left alert-dismissible" role="alert" id="alertaLecturaImagen" style="margin: 10px; display:none;">
                            <h6 class="alert-heading"><i class="fas fa-info-circle" style="font-size: 15px;"></i>&nbsp;
                                Si los valores identificados no corresponden a los de la imagen, por favor modificar o ingresar estos valores de forma manual.
                            </h6>
                        </div>
                        <div v-show="procesando" id="procesando"  style="display:none;">
                            <span><b>PROCESANDO&nbsp;</b></span>
                            <div class="spinner-grow spinner-grow-sm"></div>
                            <div class="spinner-grow spinner-grow-sm"></div>
                            <div class="spinner-grow spinner-grow-sm"></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-12 text-center">
                                <figure v-if="imgFactura != ''">
                                    <img width="220" height="240" alt="Imagen" :src="imagen" class="img img-thumbnail">
                                </figure>
                            </div>
                            <div class="col-12 text-center" id="mostrarTextoIdentificado" style="display:none;">
                                <a type="button" @click="modalTextoIdentificado = true" class="btn btn-success mb-2 text-white">
                                    <i class="fa fa-search"></i>&nbsp;Ver Texto Identificado
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-danger text-left" role="alert" id="alertaCuenta" style="margin: 10px; display:none;">
                        <h6 class="alert-heading"><i class="fas fa-exclamation-triangle" style="font-size: 15px;"></i>&nbsp;
                            No existen cuentas configuradas para el usuario y empresa.
                        </h6>
                    </div>
                    <div class="modal-footer">
                        <span class="msjGuardando" style="display:none">
                            <span>Guardando registro...</span>
                            <div class="spinner-grow spinner-grow-lg text-secondary" role="status">
                            </div>
                        </span>
                        <button type="submit" class="btn btn-primary btn-sm" :disabled="buttonDisable">Guardar Registro</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="modal" :class="{mostrar:modalTextoIdentificado}">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Texto Identificado</h4>
                        <button @click="cerrarModalTexto()" type="button" class="close" >&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="row mb-2">
                            <ul id="textoIdentificado" style="list-style: none;"></ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button @click="cerrarModalTexto()" class="btn btn-primary btn-sm">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>


    </div>
    </div>
</template>
<script>
import datatable from 'datatables.net-bs4';
import datatableres from 'datatables.net-responsive';
import datatableresbs4 from 'datatables.net-responsive-bs4';
import moment from "moment";
import {Money} from 'v-money'
import Tesseract from 'tesseract.js';
import {Chart} from 'highcharts-vue'

/*var elemento = document.getElementById('btnDetalle');
elemento.addEventListener("click", function() {
   alert("You clicked me");
}​);​

function myFunction(idElemento) {
    var elemento = document.getElementById(idElemento);
    if(idElemento == "tblTransacciones"){
        //elemento.style.display = "block";
        var elementoOculta = document.getElementById("divGraficos");
        elementoOculta.style.display = "none";
    }else if(idElemento == "divGraficos"){
        //elemento.style.display = "block";
        var elementoOculta = document.getElementById("tblTransacciones");
        elementoOculta.style.display = "none";
    }
    elemento.style.display = "block";
}*/

var valorIngreso = 0;

function validaFormulario(){
    let respuesta = true;
    let arrayCampos = ['fecha',
                        'tipo',
                        //'categoria',
                        //'cuenta',
                        'tarifacero',
                        'tarifadifcero',
                        'iva',
                        'importe',
                        'detalle',
                        'inputFile',
                        'TOTAL',
                        'NUMERO-FACTURA'];

    arrayCampos.forEach( function(valor, indice) {
        let valorElemento = document.getElementById(valor).value;

        if(valorElemento === ""){
            respuesta = false;
            if(valor == "inputFile"){
                document.getElementById("fileIcon").style.color = "red";
            }else{
                document.getElementById(valor).style.borderColor = "red";
            }
            document.querySelectorAll(".campo-obligatorio").forEach(el => el.classList.remove("d-none"));
        }else if(valorElemento == 0 || valorElemento == 0.00){
            document.getElementById(valor).style.borderColor = "#e2e2e3";
        }else{
            if(valor == "inputFile"){
                document.getElementById("fileIcon").style.color = "#6777ef";
            }else{
                document.getElementById(valor).style.borderColor = "#e2e2e3";
            }
            document.querySelectorAll(".campo-obligatorio").forEach(el => el.classList.add("d-none"));
        }
    });

    return respuesta;
}

/*var observer = new IntersectionObserver(function(entries) {
	if(entries[0].isIntersecting === true)
		console.log('Element is fully visible in screen');
}, { threshold: [1] });

observer.observe(document.querySelector("#main-container"));*/

var elements = document.getElementsByClassName('applyBtn');
var requiredElement = elements[0];

/*requiredElement.addEventListener('click', function(e) {
    console.log("CLK");
}, false);*/

export default {
    name: "IngresoManualComprobante",
    props: ['listaTransacciones', 'subServicio', 'plan', 'tipoPlan', 'sumaIngresos', 'sumaEgresos', 'categorias', 'userEmpresa', 'empresa', 'flagPermisoPlanCuentas', 'servicioUsuario', 'userId'],
    data() {
        let arrayComprobantes = [];
        var resultado = [];
        let listaCategorias = JSON.parse(this.categorias);
        var flagPermisoCuentas = false;

        for (const key in listaCategorias){
            resultado.push({
                name: key,
                y: parseFloat(listaCategorias[key]),
            });
        }

        if (this.listaTransacciones.indexOf('},{') > -1)
        {
            let jsonstring = this.listaTransacciones.replace('[','').replace(']','').replaceAll('},{','}**STRINGSPLIT**{').replaceAll("'","");
            let split = jsonstring.split("**STRINGSPLIT**");
            if(split.length > 0)
            {
                split.forEach( function(valor, indice) {
                    arrayComprobantes.push(JSON.parse(valor));
                });
            }
        }else if (this.listaTransacciones.indexOf('{') > -1){
            let jsonstring = this.listaTransacciones.replace('[','').replace(']','').replaceAll("'","");
            arrayComprobantes.push(JSON.parse(jsonstring));
        }
        //console.log(this.flagPermisoPlanCuentas);
        if(this.flagPermisoPlanCuentas == "true")
            flagPermisoCuentas = true;
        else if(this.flagPermisoPlanCuentas == "false")
            flagPermisoCuentas = false;

        return {
            modalNuevoRegistro: false,
            procesando: false,
            imagenMiniatura: '',
            imgFactura: '',
            comprobante: {
                fecha: moment().format('YYYY-MM-DD'),
                tipo_transaccion: '',
                cuenta: '',
                tarifacero: 0,
                tarifadifcero: 0,
                iva: 0,
                importe: 0,
                detalle: '',
                tipo_categoria: '',
                empresa_transaccion: '',
                porcentajeRetencionImpuestoRenta: 0,
                totalRetencion: 0,
            },
            tipoTransaccion: [],
            categoria: [],
            transacciones:arrayComprobantes,
            cuentas: [],
            sustento: [],
            tipoComprobante: [],
            formasCobro: [],
            retencionFuenteIva: [],
            retencionImpuestoRenta: [],
            retencionesIR: [],
            retencionesFI: [],
            disablePorcentajeRIR: true,
            disableTotalRetencion: true,
            flagCuenta: true,
            flagPermiso: flagPermisoCuentas,
            buttonDisable: false,
            porcentajeRetencionIva: 0,
            //empresa: [],
            sumaIngresosGrafico: this.sumaIngresos,
            sumaEgresosGrafico: this.sumaEgresos,
            sumaCategorias: resultado,
            chartOptions : {},
            chartOptionsPie : {},
            mostrarSustento: false,
            mostrarTipoComprobante: false,
            modalTextoIdentificado: false,
            mostrarTextoIdentificado: false,
            textoIdentificado: "",
            formasCobroPago: "Cobro"
        }
    },
    created() {
        this.listarTipoTransaccion();
        this.listarCategoria();
        this.listarCuentas();
        this.listarSustento();
        this.listarTipoComprobante();
        this.listarFormasCobro();
        this.listarRetencionFuenteIva();
        this.listarRetencionImpuestoRenta();
        this.retencionesImpuestoRenta();
        this.retencionesFuenteIva();
        //this.listarEmpresas();
        //this.$tablaGlobal("#tblTransacciones");
        this.generarDataTable();
        this.mostrarGraficos("", "");
    },
    //El total de la retención es el valor retenido de la Ret. En la Fte. Del Imp a la renta y la retención en la fuente del IVA
    /*
    totalRetencion
    watch: {
        sumaIngresosGrafico(newSumaIngresos) {
            console.log("-- sumaIngresosGrafico --");
            console.log(newSumaIngresos);
            this.sumaIngresosGrafico = newSumaIngresos;
        },
        sumaEgresosGrafico(newSumaEgresos) {
            console.log("-- sumaEgresosGrafico --");
            console.log(newSumaEgresos);
            this.sumaEgresosGrafico = newSumaEgresos;
        },
    },*/
    components: {
        highcharts: Chart
    },
    methods: {
        seleccionaRIR(event){
            const selectedIndex = event.target.selectedIndex;
            const selectedOption = event.target.options[selectedIndex];
            const selectedText = selectedOption.textContent;

            if(this.retencionesIR[selectedIndex].codigo_formulario.includes(",")){
                this.disablePorcentajeRIR = false;
            }else{
                this.comprobante.porcentajeRetencionImpuestoRenta = this.retencionesIR[selectedIndex].porcentaje;
                this.calculaRetencionTotal();
            }
        },
        seleccionaRFI(event){
            const selectedIndex = event.target.selectedIndex;
            const selectedOption = event.target.options[selectedIndex];
            const selectedText = selectedOption.textContent;

            this.porcentajeRetencionIva = this.retencionesFI[selectedIndex].porcentaje_retencion_iva;

            this.calculaRetencionTotal();
        },
        calculaRetencionTotal(){
            console.log(this.porcentajeRetencionIva);
            console.log(this.comprobante.porcentajeRetencionImpuestoRenta);

            this.comprobante.totalRetencion = parseFloat(this.porcentajeRetencionIva) + parseFloat(this.comprobante.porcentajeRetencionImpuestoRenta);
        },
        validaTipoTransaccion(event){
            const selectedIndex = event.target.selectedIndex;
            const selectedOption = event.target.options[selectedIndex];
            const selectedText = selectedOption.textContent;

            if(selectedText == "FACTURA COMPRA"){
                this.mostrarTipoComprobante = false;
                this.mostrarSustento = true;
            }

            if(selectedText == "FACTURA COMPRA" || selectedText == "EGRESOS"){
                this.formasCobroPago = "Pago";
            }

            if(selectedText == "FACTURA VENTA"){
                this.mostrarSustento = false;
                this.mostrarTipoComprobante = true;
            }

        },
        mostrarGraficos(maxDate, minDate){
            console.log(maxDate);
            console.log(minDate);
            console.log("***");
            if(maxDate !== "" && minDate !== ""){
                let sumas = this.actualizarGrafico(maxDate, minDate);

                sumas.then((data) => {
                    this.sumaIngresosGrafico = data.data.sumaIngresos;
                    this.sumaEgresosGrafico = data.data.sumaEgresos;

                    var resultado = [];
                    let listaCategorias = data.data.categorias;

                    var flagPermisoCuentas = false;

                    for (const key in listaCategorias){
                        resultado.push({
                            name: key,
                            y: parseFloat(listaCategorias[key]),
                        });
                    }

                    this.sumaCategorias =  resultado;

                    /*var resultado = [];
                    let listaCategorias = data.data.categorias;
                    var flagPermisoCuentas = false;

                    for (const key in listaCategorias){
                        resultado.push({
                            name: key,
                            y: parseFloat(listaCategorias[key]),
                        });
                    }*/

                    this.dibujaChart();
                    this.dibujaPie();
                });
                //this.actualizarGrafico(maxDate, minDate);

            }else{
                this.dibujaChart();
                this.dibujaPie();
            }

        },
        dibujaChart(){
            this.chartOptions = {
                series: [{
                    color: '#21618c',
                    data: [

                        {
                            name: 'INGRESOS',
                            color: '#2196f3',
                            y: parseFloat(this.sumaIngresosGrafico)
                        },
                        {
                            name: 'EGRESOS',
                            color: '#dc3545',
                            y: parseFloat(this.sumaEgresosGrafico)
                        }
                    ],
                }],
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Resumen general'
                },
                plotOptions: {
                    bar: {
                        dataLabels: {
                            enabled: false,
                        },
                    },
                    column: {
                        pointWidth: 125,
                        borderWidth: 1
                    },
                },
                legend: {
                    enabled: false
                },
                yAxis: {
                    allowDecimals: false,
                    title: {
                        text: ''
                    }
                },
                xAxis: {
                    categories: ['SUMAS (+)','RESTAS (-)'],
                },
                tooltip: {
                    formatter: function () {
                    return "<b>$"+this.y+"</b>";
                    }
                },
            };
        },
        dibujaPie(){
            this.chartOptionsPie = {
                series: [{
                    color: '#21618c',
                    data: this.sumaCategorias,
                }],
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'Resumen por categorías'
                },
                plotOptions: {
                    bar: {
                        dataLabels: {
                            enabled: false
                        },
                    },
                    column: {
                        pointWidth: 125,
                        borderWidth: 2
                    },
                },
                legend: {
                    enabled: true
                },
                yAxis: {
                    allowDecimals: true,
                    title: {
                        text: 'categoría'
                    }
                },
                tooltip: {
                    formatter: function () {
                    return "<b>$"+this.y+"</b>";
                    }
                },
            };
        },
        mostrarElementos(idElemento){
            var elemento = document.getElementById(idElemento);
            if(idElemento == "tblTransacciones_wrapper"){
                var elementoOculta = document.getElementById("divGraficos");
                elementoOculta.style.display = "none";
            }else if(idElemento == "divGraficos"){
                var elementoOculta = document.getElementById("tblTransacciones_wrapper");
                elementoOculta.style.display = "none";
            }
            elemento.style.display = "block";
        },
        generarDataTable(){
            this.$nextTick(()=>{
                var minDateFilter = '';
                var maxDateFilter = '';
                const self = this;

                $("#tblTransacciones").DataTable().destroy();
                var tabla = $("#tblTransacciones").DataTable({
                    "retrieve": true,
                    "bDeferRender": true,
                    "autoWidth": false,
                    "order": [[ 0, "desc" ]],
                    "search": {
                        "regex": true,
                        "caseInsensitive": false,
                    },
                    "destroy": true,
                    "sPaginationType": "full_numbers",
                    "language":{
                        "sProcessing":     "Procesando...",
                        "sLengthMenu":     "Mostrar _MENU_ registros",
                        "sZeroRecords":    "",
                        "sEmptyTable":     "No existen registros",
                        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                        "sInfoPostFix":    "",
                        "sSearch":         "Buscar:",
                        "sUrl":            "",
                        "sInfoThousands":  ",",
                        "sLoadingRecords": "Cargando...",
                        "oPaginate": {
                            "sFirst":    "<i class='fa fa-fast-backward' aria-hidden='true'></i>",
                            "sLast":     "<i class='fa fa-fast-forward' aria-hidden='true'></i>",
                            "sNext":     "<i class='fa fa-step-forward' aria-hidden='true'></i>",
                            "sPrevious": "<i class='fa fa-step-backward' aria-hidden='true'></i>"
                        },
                        "oAria": {
                            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                        }
                    },
                    "responsive": true,
                    //dom: 'Bfrtip',
                });

                $('.inputDateRange').daterangepicker({
                    startDate: moment(),
                    endDate: moment(),
                    locale: {
                        format: 'YYYY/MM/DD',
                        "separator": " - ",
                        "applyLabel": "Aplicar",
                        "cancelLabel": "Cancelar",
                        "fromLabel": "DE",
                        "toLabel": "HASTA",
                        "customRangeLabel": "Custom",
                        "daysOfWeek": [
                            "Dom",
                            "Lun",
                            "Mar",
                            "Mie",
                            "Jue",
                            "Vie",
                            "Sáb"
                        ],
                        "monthNames": [
                            "Enero",
                            "Febrero",
                            "Marzo",
                            "Abril",
                            "Mayo",
                            "Junio",
                            "Julio",
                            "Agosto",
                            "Septiembre",
                            "Octubre",
                            "Noviembre",
                            "Diciembre"
                        ],
                        "firstDay": 1,
                        "opens": "center",
                    }
                }, function(start, end, label) {
                    maxDateFilter = end;
                    minDateFilter = start;
                    tabla.draw();
                    self.mostrarGraficos(maxDateFilter.format('YYYY-MM-DD'), minDateFilter.format('YYYY-MM-DD'));
                });

                /*$('.resetDateFilter').click(function(){
                    
                });*/

                $.fn.dataTableExt.afnFiltering.push(
                    function(oSettings, aData, iDataIndex){
                        if(typeof aData._date == 'undefined'){
                            aData._date = new Date(aData[0]).getTime();
                        }

                        if(minDateFilter && !isNaN(minDateFilter)){
                            if(aData._date < minDateFilter){
                                return false;
                            }
                        }

                        if(maxDateFilter && !isNaN(maxDateFilter)){
                            if(aData._date > maxDateFilter){
                                return false;
                            }
                        }
                        return true;
                    }
                );

            });
        },
        cerrarModal(){
            var camposImagen = document.getElementById("camposImagen");
            camposImagen.style.display = "none";

            var alertaTipoImagen = document.getElementById("alertaTipoImagen");
            alertaTipoImagen.style.display = "none";

            var alertaLecturaImagen = document.getElementById("alertaLecturaImagen");
            alertaLecturaImagen.style.display = "none";

            document.querySelectorAll(".campo-obligatorio").forEach(el => el.classList.add("d-none"));
            document.querySelectorAll(".form-control").forEach(el => el.style.borderColor = "#e2e2e3");

            var mostrar = document.getElementById("mostrarTextoIdentificado");
            mostrar.style.display = "none";

            const ul = document.getElementById('textoIdentificado');

            while (ul.firstChild) {
                ul.removeChild(ul.firstChild);
            }

            this.mostrarSustento = false;
            this.mostrarTipoComprobante = false;
            this.modalNuevoRegistro = false;
        },
        cerrarModalTexto(){
            this.modalTextoIdentificado = false;
        },
        abrirInputFile(){
            $('#inputFile').click();
        },
        resetDate() {
            window.location.reload();
		},
        async obtenerImagen(e){
            var file = e.target.files[0];

            var camposImagen = document.getElementById("camposImagen");
            if(camposImagen)
                camposImagen.remove();

            let alertaLecturaImagen = document.getElementById("alertaLecturaImagen");
            alertaLecturaImagen.style.display = "none";

            let alertaTipoImagen = document.getElementById("alertaTipoImagen");
            alertaTipoImagen.style.display = "none";

            //this.procesando = true;
            if(file.type.includes("png") || file.type.includes("jpg") || file.type.includes("jpeg"))
            {
                var proceso = document.getElementById("procesando");
                if (proceso.style.display === "none") {
                    proceso.style.display = "block";
                } else {
                    proceso.style.display = "none";
                }

                let reader = new FileReader();
                reader.onload = function() {

                    let url = '/admin/ingreso_facturas/leer_factura';
                    const config = {
                        headers: {
                            'content-type': 'multipart/form-data'
                        }
                    };

                    let data = new FormData();
                    data.append('img_factura', reader.result);

                    let datos ={
                        url : url,
                        config: config,
                        data: data
                    };

                    axios.post(datos.url, datos.data, datos.config)
                        .then((response) => {
                            var contenedorPrincipal = document.getElementById("contenedorCamposImagen");
                            var spanElementos = document.createElement('div');
                            spanElementos.setAttribute("id", "camposImagen");
                            contenedorPrincipal.appendChild(spanElementos);

                            var inputContainer = document.getElementById("camposImagen");
                            var date = new Date();
                            var fechaActual = date.toISOString().substring(0,10);

                            if (response.data.flagEncontrado == false){
                                //var dataImagen = ["TOTAL", "NUMERO-FACTURA", "FECHA-FACTURA", "IVA"];
                                var dataImagen = [];
                                dataImagen['TOTAL'] = 0;
                                dataImagen['NUMERO-FACTURA'] = '';
                                dataImagen['FECHA-FACTURA'] = fechaActual;
                                dataImagen['IVA'] = 0;
                            }else{
                                var dataImagen = response.data.arrayValoresImagen;
                                var mostrar = document.getElementById("mostrarTextoIdentificado");
                                mostrar.style.display = "block";
                                var ul = document.getElementById("textoIdentificado");
                                response.data.textoCompleto.forEach(item => {
                                    const li = document.createElement('li');
                                    li.textContent = item;
                                    ul.appendChild(li);
                                });
                            }

                                for (const key in dataImagen) {
                                    if(key == "IVA"){
                                        let ivaInput = document.getElementById("iva");
                                        ivaInput.value = dataImagen[key];
                                    }else if(key == "FECHA-FACTURA"){
                                        let fechaInput = document.getElementById("fecha");
                                        fechaInput.value = fechaActual;//dataImagen[key];
                                    }else{
                                        var newDiv = document.createElement("div");
                                        newDiv.classList.add('form-group', 'row', 'mb-2');
                                        var inputIcono = "";
                                        var classInputIcono = "";

                                        if(key !== "NUMERO-FACTURA"){
                                            inputIcono = "<div class='input-group-prepend'><span class='input-group-text' id='inputGroup-sizing-sm'><small>$</small></span></div>";
                                            classInputIcono = "input-group";
                                        }

                                        //let htmlInterno = "<label class='col-4 col-form-label'><b>"+key.replace("-", " ")+"</b></label>"+
                                        //                    "<div class='col-8'>"+
                                        //                    "<input type='text' class='form-control text-right' value="+dataImagen[key]+">"+
                                        //                    "<span class='text-danger campo-obligatorio d-none'>Campo Obligatorio</span></div>";

                                        let htmlInterno = "<label class='col-4 col-form-label'><b>"+key.replace("-", " ")+"</b></label>"+
                                                            "<div class='col-8 "+classInputIcono+"'>"+inputIcono+
                                                            "<input type='text' class='form-control text-right' id='"+key+"' value="+dataImagen[key]+"/></div>"+
                                                            "<div class='col-8 text-right'><span class='text-danger campo-obligatorio d-none'>Campo Obligatorio</span></div>"+
                                                            "</div>";

                                        newDiv.innerHTML = htmlInterno;
                                        inputContainer.appendChild(newDiv);
                                    }
                                }

                            var proceso = document.getElementById("procesando");

                            if (proceso.style.display === "none") {
                                proceso.style.display = "block";
                            }else{
                                proceso.style.display = "none";
                            }

                            let alerta = document.getElementById("alertaLecturaImagen");
                            alerta.style.display = "block";
                        });
                }
                reader.readAsDataURL(file);
                this.imgFactura = file;
                this.cargarImagen(file);

            }else{
                let alerta = document.getElementById("alertaTipoImagen");
                alerta.style.display = "block";
            }
        },
        cargarImagen(file){
            let reader = new FileReader();
            reader.onload = (e) => {
                this.imagenMiniatura = e.target.result;
            };
            reader.readAsDataURL(file);
        },
        async listarTipoTransaccion(){
            const respuesta = await axios.get('/admin/ingreso_facturas/listar_tipo_transaccion');
            this.tipoTransaccion = respuesta.data;
        },
        async listarCategoria(){
            const respuestaCategoria = await axios.get('/admin/ingreso_facturas/listar_categoria');
            this.categoria = respuestaCategoria.data;
        },
        async listarCuentas(){
            const respuestaCuentas= await axios.get('/admin/ingreso_facturas/listar_cuentas/'+this.userEmpresa);
            this.cuentas = respuestaCuentas.data;
            if(respuestaCuentas.data.length == 0){
                this.flagCuenta = false;
            }
        },
        async listarSustento(){
            const respuestaSustento = await axios.get('/admin/ingreso_facturas/listar_sustento');
            this.sustento = respuestaSustento.data;
        },
        async listarTipoComprobante(){
            const respuestaTipoComprobante = await axios.get('/admin/ingreso_facturas/listar_tipoComprobante');
            this.tipoComprobante = respuestaTipoComprobante.data;
        },
        async listarFormasCobro(){
            const respuestaFormasCobro = await axios.get('/admin/ingreso_facturas/listar_formasCobro');
            this.formasCobro = respuestaFormasCobro.data;
        },
        async listarRetencionFuenteIva(){
            const respuestaRetencionIva = await axios.get('/admin/ingreso_facturas/listar_retencionIva');
            this.retencionFuenteIva = respuestaRetencionIva.data;
        },
        async retencionesFuenteIva(){
            const respuesta = await axios.get('/admin/ingreso_facturas/retencionesFuenteIva');
            this.retencionesFI = respuesta.data;
        },
        async listarRetencionImpuestoRenta(){
            const respuestaRetencionImpuestoRenta= await axios.get('/admin/ingreso_facturas/listar_retencionImpuestoRenta');
            this.retencionImpuestoRenta = respuestaRetencionImpuestoRenta.data;

            /*
            var resultado = [];
            console.log(this.retencionImpuestoRenta);
            let listaCategorias = JSON.parse(this.retencionImpuestoRenta);
            console.log(listaCategorias);
            var flagPermisoCuentas = false;

            for (const key in listaCategorias){
                resultado.push({
                    name: key,
                    y: parseFloat(listaCategorias[key]),
                });
            }

            this.sumaCategorias = resultado;
            */
        },
        async retencionesImpuestoRenta(){
            const respuesta = await axios.get('/admin/ingreso_facturas/retencionesImpuestoRenta');
            this.retencionesIR = respuesta.data;
        },
        async actualizarGrafico(maxDate, minDate){
            const respuestaGrafico = await axios.get('/admin/ingreso_facturas/valores_grafico/'+this.servicioUsuario+'/'+minDate+'/'+maxDate);
            return respuestaGrafico;

        },
        /*async listarEmpresas(){
            const respuestaEmpresas = await axios.get('/admin/ingreso_facturas/listar_empresas');
            this.empresa = respuestaEmpresas.data;
        },*/
        resetForm(){
            this.comprobante.fecha = moment().format('YYYY-MM-DD');
            this.comprobante.tipo_transaccion = '';
            this.comprobante.cuenta = '';
            this.comprobante.tarifacero = 0;
            this.comprobante.tarifadifcero = 0;
            this.comprobante.iva = 0;
            this.comprobante.ivaPorcentaje = 0;
            this.comprobante.importe = 0;
            this.imgFactura = '';
            this.imagenMiniatura = '';
            this.comprobante.detalle = '';
            this.comprobante.tipo_categoria = '';
            this.comprobante.empresa_transaccion = '';
            this.comprobante.sustentoTributario = '';
            this.comprobante.tipoComprobante = '';
            this.comprobante.formas_cobro = '';
            this.comprobante.retencion_fuente_iva = '';
            this.comprobante.retencion_impuesto_renta = '';
            this.comprobante.porcentajeRetencionImpuestoRenta = 0;
            //let flagCuenta = true;

            if(this.flagPermiso){
                if(!this.flagCuenta){
                    document.getElementById("alertaCuenta").style.display = "block";
                    this.buttonDisable = true;
                }
            }
        },
        storeService() {
            let respuestaValidacion = validaFormulario();

            if(respuestaValidacion){
                document.getElementsByClassName('msjGuardando')[0].style.display = "block";
                let set = this;
                let url = '/admin/ingreso_facturas/store';
                const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                };

                let file = document.getElementById('inputFile').files[0];
                let data = new FormData();

                data.append('fecha', this.comprobante.fecha);
                if (this.imgFactura !== null) {
                    data.append('imagenBase64', this.imagenMiniatura);
                    data.append('nombreFactura', file.name);
                }
                data.append('tipo_transaccion', this.comprobante.tipo_transaccion);
                data.append('cuenta', this.comprobante.cuenta);
                data.append('tarifacero', this.comprobante.tarifacero);
                data.append('tarifadifcero', this.comprobante.tarifadifcero);
                data.append('iva', this.comprobante.iva);
                data.append('ivaPorcentaje', this.comprobante.ivaPorcentaje);
                data.append('importe', this.comprobante.importe);
                data.append('detalle', this.comprobante.detalle);
                data.append('tipo_categoria', this.comprobante.tipo_categoria);
                data.append('empresa_transaccion', this.userEmpresa);
                data.append('estado', 'activo');
                data.append('subServicio',this.subServicio);
                data.append('user_id',this.userId);
                data.append('plan',this.plan);
                data.append('sustento',this.comprobante.sustentoTributario);
                data.append('tipoComprobante',this.comprobante.tipoComprobante);
                data.append('formasCobro',this.comprobante.formas_cobro);
                data.append('retencionFuenteIva',this.comprobante.retencion_fuente_iva);
                data.append('retencionImpuestoRenta',this.comprobante.retencion_impuesto_renta);
                data.append('porcentajeRetencionImpuestoRenta',this.comprobante.porcentajeRetencionImpuestoRenta);

                let datos ={
                    url : url,
                    config: config,
                    data: data
                };

                axios.post(datos.url, datos.data, datos.config)
                    .then(function(res) {
                        //this.buttonDisable = true;
                        document.getElementsByClassName('msjGuardando')[0].style.display = "none";
                        //let link = "/admin/ingreso_facturas/ingreso_manual/"+this.subServicio+"/"+this.tipoPlan+"/";
                        //window.location = link;
                        window.location.href = window.location.href.split('#')[0];
                    })
                    .catch(function(error) {
                        //if (error.response.status == 422) {
                            //set.errors.record(error.response.datos.errors);
                        //}
                        //set.buttonDisable = false;
                    });

            }
        },
    },
    computed: {
        imagen(){
            return this.imagenMiniatura;
        }
    },
}
</script>
<style scoped>
.mostrar {
    display: list-item;
    opacity: 1;
    background-color: rgba(14, 21, 66, 0.445);
    overflow: auto;
}
.form-control-sm {
    height: calc(1.5em + .5rem + 2px) !important;
    padding: .25rem .5rem !important;
    font-size: .875rem !important;
    line-height: 1.5 !important;
    border-radius: .2rem !important;
}
</style>
