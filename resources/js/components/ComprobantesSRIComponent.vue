<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 text-center">
                                <div v-show="!ocultarDropZone">
                                    <h6>Haga click en el recuadro, o arrastre el archivo .txt</h6>
                                    <hr>
                                    <vue-dropzone ref="dropzone" id="dropzone" class="customDropzone"
                                        :options="dropzoneOptions"
                                        @vdropzone-success="archivoProcesado"
                                        @vdropzone-processing="inicioEnvio"
                                        @vdropzone-complete="cargaCompleta">
                                    </vue-dropzone>
                                </div>
                                <div class="alert alert-success" v-show="!ocultarCarga">
                                    <span class="h4">Procesando archivo, espere por favor</span>
                                    <div class="spinner-grow spinner-grow-sm"></div>
                                    <div class="spinner-grow spinner-grow-sm"></div>
                                    <div class="spinner-grow spinner-grow-sm"></div>
                                </div>
                                <div class="alert alert-success" id="mensajeGuardando" style="display: none">
                                    <span class="h4">Guardando informaci&oacute;n, espere por favor</span>
                                    <div class="spinner-grow spinner-grow-sm"></div>
                                    <div class="spinner-grow spinner-grow-sm"></div>
                                    <div class="spinner-grow spinner-grow-sm"></div>
                                </div>
                                <div class="alert alert-success text-left alert-dismissible" role="alert" id="alertaGuardado" style="display: none">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4><i class="fas fa-check-circle" style="font-size: 18px;"></i>&nbsp;Informaci&oacute;n ingresada exitosamente.</h4>
                                </div>
                                <div v-show="!ocultarTabla">
                                    <h4 class="mb-4">
                                        Lista de Comprobantes
                                        <div class="btn-group btn-group-sm float-right">
                                            <button :disabled="disabledGuardar" @click="guardarRegistrosAuto()" class="btn btn-success" title="Guardar Comprobantes"><i class="fa fa-save fa-2x" aria-hidden="true"></i></button>
                                            <button @click="reiniciar()" class="btn btn-primary" title="Regresar"><i class="fa fa-arrow-left fa-2x" aria-hidden="true"></i></button>
                                        </div>
                                    </h4>
                                    <div class="alert alert-danger text-left alert-dismissible" role="alert" id="alertaValida" style="display: none">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <i class="fas fa-exclamation-circle"></i>
                                        <b>&nbsp;Error:</b>
                                        Ingresar informaci&oacute;n correspondiente a: categor&iacute;a, tipo de transacci&oacute;n.
                                    </div>
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#factura">Facturas <span v-text="contFacturas" class="badge badge-primary"></span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#nota_credito">Notas de Crédito <span v-text="contNotaCredito" class="badge badge-success"></span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#nota_debito">Notas de Débito <span v-text="contNotaDebito" class="badge badge-info"></span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#retenciones">Comprobantes de Retención <span v-text="contRetenciones" class="badge badge-warning"></span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#liquidaciones">Liquidaciones <span v-text="contLiquidaciones" class="badge badge-secondary"></span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#errores">Errores <span v-text="contErrores" class="badge badge-danger"></span></a>
                                        </li>
                                    </ul>
                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div class="tab-pane container active px-0 pt-2" id="factura">
                                            <div class="table-responsive">
                                                <span class="badge badge-primary"><h5>Suma total facturas:&nbsp;$<span>{{totalFacturas}}</span></h5></span>
                                                <table class="table  table-striped table-condensed table-bordered table-sm table-hover" style="width:100%;" id="tablaFacturas">
                                                    <thead>
                                                        <th>N°</th>
                                                        <th>Fecha Emisión</th>
                                                        <th>Raz&oacute;n Social Emisor</th>
                                                        <th>T. Comprobante</th>
                                                        <th>Categor&iacute;a</th>
                                                        <th>Tipo de transacci&oacute;n</th>
                                                        <th>SubTotal</th>
                                                        <th>Descuento</th>
                                                        <th>Tarifa Dif. Cero</th>
                                                        <th>Tarifa Cero</th>
                                                        <th>Iva</th>
                                                        <th>Total</th>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="item in facturas" :key="item.key">
                                                            <td>{{ item.key + 1 }}</td>
                                                            <td>{{ item.fechaEmision }}</td>
                                                            <td>{{ item.razonSocial }}</td>
                                                            <td>{{ item.tipoComprobante }}</td>
                                                            <td>
                                                                <select class="form-control form-control-sm inputValida" id="categoria" required>
                                                                    <option value="">Seleccionar categor&iacute;a</option>
                                                                    <option v-for="item in categoria" :key="item.id" :value="item.id" v-text="item.descripcionCodigo"></option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-control form-control-sm inputValida" id="tipoTransaccion" required>
                                                                    <option value="">Seleccionar tipo</option>
                                                                    <option v-for="item in tipoTransaccion" :key="item.id" :value="item.id" v-text="item.nombre"></option>
                                                                </select>
                                                            </td>
                                                            <td>${{ item.subTotal }}</td>
                                                            <td>${{ item.descuento }}</td>
                                                            <td>${{ item.tarifaDifCero }}</td>
                                                            <td>${{ item.tarifaCero }}</td>
                                                            <td>${{ item.iva }}</td>
                                                            <td>${{ item.importeTotal }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                
                                            </div>
                                        </div>
                                        <div class="tab-pane container fade px-0 pt-2" id="nota_credito">
                                            <div class="table-responsive">
                                                <span class="badge badge-primary"><h5>Suma total notas de cr&eacute;dito:&nbsp;$<span>{{totalNotasCredito}}</span></h5></span>
                                                <table class="table table-striped table-condensed table-bordered table-sm table-hover">
                                                    <thead>
                                                        <th>N°</th>
                                                        <th>Fecha Emisión</th>
                                                        <th>T. Comprobante</th>
                                                        <th>Tarifa Dif. Cero</th>
                                                        <th>Tarifa Cero</th>
                                                        <th>Iva</th>
                                                        <th>Total</th>
                                                    </thead>
                                                    <paginate name="notas_credito" :list="notas_credito" :per="numPagination" tag="tbody">
                                                        <tr v-for="(item,index) in paginated('notas_credito')" :key="item.key">
                                                            <td>{{ index + 1 }}</td>
                                                            <td>{{ item.fechaEmision }}</td>
                                                            <td>{{ item.tipoComprobante }}</td>
                                                            <td>{{ item.tarifaDifCero }}</td>
                                                            <td>{{ item.tarifaCero }}</td>
                                                            <td>{{ item.iva }}</td>
                                                            <td>{{ item.importeTotal }}</td>
                                                        </tr>
                                                    </paginate>
                                                </table>
                                                <paginate-links for="notas_credito" :classes="{'ul': 'pagination', 'li': 'page-item', 'a': 'page-link'}"></paginate-links>
                                            </div>
                                        </div>
                                        <div class="tab-pane container fade px-0 pt-2" id="nota_debito">
                                            <div class="table-responsive">
                                                <span class="badge badge-primary"><h5>Suma total notas de debito:&nbsp;$<span>{{totalNotasDebito}}</span></h5></span>
                                                <table class="table table-striped table-condensed table-bordered table-sm table-hover">
                                                    <thead>
                                                        <th>N°</th>
                                                        <th>Fecha Emisión</th>
                                                        <th>T. Comprobante</th>
                                                        <th>Tarifa Dif. Cero</th>
                                                        <th>Tarifa Cero</th>
                                                        <th>Iva</th>
                                                        <th>Total</th>
                                                    </thead>
                                                    <paginate name="notas_debito" :list="notas_debito" :per="numPagination" tag="tbody">
                                                        <tr v-for="(item,index) in paginated('notas_debito')" :key="item.key">
                                                            <td>{{ index + 1 }}</td>
                                                            <td>{{ item.fechaEmision }}</td>
                                                            <td>{{ item.tipoComprobante }}</td>
                                                            <td>{{ item.tarifaDifCero }}</td>
                                                            <td>{{ item.tarifaCero }}</td>
                                                            <td>{{ item.iva }}</td>
                                                            <td>{{ item.importeTotal }}</td>
                                                        </tr>
                                                    </paginate>
                                                </table>
                                                <paginate-links for="notas_debito" :classes="{'ul': 'pagination', 'li': 'page-item', 'a': 'page-link'}"></paginate-links>
                                            </div>
                                        </div>
                                        <div class="tab-pane container fade px-0 pt-2" id="retenciones">
                                            <div class="table-responsive">
                                                <span class="badge badge-primary"><h5>Suma total retenciones:&nbsp;$<span>{{totalRetenciones}}</span></h5></span>
                                                <table class="table table-striped table-condensed table-bordered table-sm table-hover">
                                                    <thead>
                                                        <th>N°</th>
                                                        <th>Fecha Emisión</th>
                                                        <th>T. Comprobante</th>
                                                        <th>T. Impuesto</th>
                                                        <th>% Retenido</th>
                                                        <th>Base Imponible</th>
                                                        <th>Valor Ret.</th>
                                                    </thead>
                                                    <paginate name="retenciones" :list="retenciones" :per="numPagination" tag="tbody">
                                                        <tr v-for="(item,index) in paginated('retenciones')" :key="item.key">
                                                            <td>{{ index + 1 }}</td>
                                                            <td>{{ item.fechaEmision }}</td>
                                                            <td>{{ item.tipoComprobante }}</td>
                                                            <td>{{ item.tipoImp }}</td>
                                                            <td>{{ item.porcRet }}</td>
                                                            <td>{{ item.baseImponible }}</td>
                                                            <td>{{ item.valorRet }}</td>
                                                        </tr>
                                                    </paginate>
                                                </table>
                                                <paginate-links for="retenciones" :classes="{'ul': 'pagination', 'li': 'page-item', 'a': 'page-link'}"></paginate-links>
                                            </div>
                                        </div>
                                        <div class="tab-pane container fade px-0 pt-2" id="liquidaciones">
                                            <div class="table-responsive">
                                                <span class="badge badge-primary"><h5>Suma total liquidaciones:&nbsp;$<span>{{totalLiquidaciones}}</span></h5></span>
                                                <table class="table table-striped table-condensed table-bordered table-sm table-hover">
                                                    <thead>
                                                        <th>N°</th>
                                                        <th>Fecha Emisión</th>
                                                        <th>T. Comprobante</th>
                                                        <th>SubTotal</th>
                                                        <th>Descuento</th>
                                                        <th>Tarifa Dif. Cero</th>
                                                        <th>Tarifa Cero</th>
                                                        <th>Iva</th>
                                                        <th>Total</th>
                                                    </thead>
                                                    <paginate name="liquidaciones" :list="liquidaciones" :per="numPagination" tag="tbody">
                                                        <tr v-for="(item,index) in paginated('liquidaciones')" :key="item.key">
                                                            <td>{{ index + 1 }}</td>
                                                            <td>{{ item.fechaEmision }}</td>
                                                            <td>{{ item.tipoComprobante }}</td>
                                                            <td>{{ item.subTotal }}</td>
                                                            <td>{{ item.descuento }}</td>
                                                            <td>{{ item.tarifaDifCero }}</td>
                                                            <td>{{ item.tarifaCero }}</td>
                                                            <td>{{ item.iva }}</td>
                                                            <td>{{ item.importeTotal }}</td>
                                                        </tr>
                                                    </paginate>
                                                </table>
                                                <paginate-links for="liquidaciones" :classes="{'ul': 'pagination', 'li': 'page-item', 'a': 'page-link'}"></paginate-links>
                                            </div>
                                        </div>
                                        <div class="tab-pane container fade px-0 pt-2" id="errores">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-condensed table-bordered table-sm table-hover">
                                                    <thead>
                                                        <th>N°</th>
                                                        <th>Clave Acceso</th>
                                                        <th>Mensaje</th>
                                                    </thead>
                                                    <paginate name="errores" :list="errores" :per="numPagination" tag="tbody">
                                                        <tr v-for="(item,index) in paginated('errores')" :key="item.key">
                                                            <td>{{ index + 1 }}</td>
                                                            <td class="text-left">{{ item.ClaveAcceso }}</td>
                                                            <td>{{ item.mensaje }}</td>
                                                        </tr>
                                                    </paginate>
                                                </table>
                                                <paginate-links for="errores" :classes="{'ul': 'pagination', 'li': 'page-item', 'a': 'page-link'}"></paginate-links>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import vue2Dropzone from 'vue2-dropzone';
    import 'vue2-dropzone/dist/vue2Dropzone.min.css';

    function validaFormulario(){
        let validaVacio = false;
        let tablaFacturas = document.getElementById('tablaFacturas');
        let colorInput = '#e4e6fc';
        let display = "none";

        for (let row of tablaFacturas.rows)
        {
            var cont = 0;
            var arrayCells = [];
            for(let cell of row.cells)
            {
                if(cont == 3 || cont == 4)
                {
                    if(cell.firstChild.value === "")
                    {
                        validaVacio = true;
                    }
                }

                cont++;
            }
        }
    
        if(validaVacio)
        {
            colorInput = 'red';
            display = "block";
        }

        var campos = document.getElementsByClassName('inputValida');

        for (var i = 0; i < campos.length; i++)
        {
            campos[i].style.borderColor = colorInput;
        }

        document.getElementById('alertaValida').style.display = display;

        return validaVacio;
    }

    const urlArray = window.location.href.split("/");
    var tipoPlan = urlArray[urlArray.length - 1];
    var subservicio = urlArray[urlArray.length - 2];

    export default {
        data(){
            return {
                dropzoneOptions: {
                    url: '/admin/procesarComprobanteSRI',
                    method: 'POST',
                    thumbnailWidth: 150,
                    maxFilesize: 1,
                    maxFiles: 1,
                    parallelUploads: 1,
                    dictDefaultMessage: "<i class='fas fa-cloud-upload-alt fa-lg' style='font-size: 2rem;'></i> Solo se permiten archivos .txt",
                    dictRemoveFile: 'Quitar',
                    dictMaxFilesExceeded: 'Solo 1 archivo',
                    dictFileTooBig: 'Archivo excede el tamaño permitido',
                    uploadMultiple: false,
                    acceptedFiles: "text/plain",
                    autoProcessQueue: true,
                    addRemoveLinks: true,
                    headers: {
                        "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                    },
                },
                facturas: [],
                notas_credito: [],
                notas_debito: [],
                retenciones: [],
                liquidaciones: [],
                categoria: [],
                tipoTransaccion: [],
                errores: [],
                totalFacturas: 0,
                totalNotasCredito: 0,
                totalNotasDebito: 0,
                totalRetenciones: 0,
                totalLiquidaciones: 0,
                inputTipoPlan: document.getElementById('inputTipoPlan').value,
                inputSubservicio: document.getElementById('inputSubservicio').value,
                inputUsuarioEmpresa: document.getElementById('inputUsuarioEmpresa').value,
                ocultarDropZone: false,
                ocultarCarga: true,
                ocultarTabla: true,
                contFacturas: 0,
                contNotaCredito: 0,
                contNotaDebito: 0,
                contRetenciones: 0,
                contLiquidaciones: 0,
                contErrores: 0,
                disabledGuardar: true,
                paginate: ['facturas','notas_credito','notas_debito','retenciones','liquidaciones','errores'],
                numPagination: 25,
            }
        },
        components: {
            vueDropzone: vue2Dropzone,
        },
        created() {
            this.listarCategoria();
            this.listarTipoTransaccion();
        },
        mounted() {

        },
        methods: {
            async listarCategoria(){
                const respuestaCategoria = await axios.get('/admin/ingreso_facturas/listar_categoria');
                this.categoria = respuestaCategoria.data;
            },
            async listarTipoTransaccion(){
                const respuesta = await axios.get('/admin/ingreso_facturas/listar_tipo_transaccion');
                this.tipoTransaccion = respuesta.data;
            },
            archivoProcesado: async function (response) {
                //console.log("****");
                console.log(response.xhr.response);
                let resp = JSON.parse(response.xhr.response);
                if(resp != 0){
                    this.facturas = resp.facturas;
                    this.contFacturas = resp.facturas.length;
                    this.totalFacturas = this.getValorTotal(resp.facturas);

                    this.notas_credito = resp.notas_credito;
                    this.contNotaCredito = resp.notas_credito.length;

                    this.notas_debito = resp.notas_debito;
                    this.contNotaDebito = resp.notas_debito.length;

                    this.retenciones = resp.retenciones;
                    this.contRetenciones = resp.retenciones.length;

                    this.liquidaciones = resp.liquidaciones;
                    this.contLiquidaciones = resp.liquidaciones.length;

                    this.errores = resp.errores;
                    this.contErrores = resp.errores.length;

                    this.ocultarDropZone = true;
                    this.ocultarCarga = true;
                    this.ocultarTabla = false;
                    if(this.contFacturas > 0 || this.contNotaCredito > 0 || this.contNotaDebito > 0 || this.contRetenciones > 0 || this.contLiquidaciones > 0){
                        this.disabledGuardar = false;
                    }
                }else{
                    Toast.fire({icon: 'error',text: 'Se ha producido un error, vuelva a intentar'});
                    this.ocultarDropZone = false;
                    this.ocultarCarga = true;
                    this.ocultarTabla = true;
                    this.disabledGuardar = true;
                }
            },
            getValorTotal: function(arrayRegistros){
                var total = 0;
                arrayRegistros.forEach((element) => {
                    let valor = parseFloat(element.importeTotal)
                    total += valor;
                });

                return parseFloat(total.toFixed(2));
            },
            inicioEnvio: function(){
                this.ocultarDropZone = true;
                this.ocultarCarga = false;
            },
            resetDropZone: function(file){
                this.$refs.dropzone.removeFile(file);
                this.ocultarDropZone = true;
                this.ocultarCarga = true;
                this.ocultarTabla = false;
            },
            cargaCompleta(file){
                this.$refs.dropzone.removeFile(file);
            },
            async exportarExcel(){
              this.postForm( '/comprobante_electronicos/exportarExcel', {
                                                                            facturas: JSON.stringify(this.facturas),
                                                                            notasCredito: JSON.stringify(this.notas_credito),
                                                                            notasDebito: JSON.stringify(this.notas_debito),
                                                                            retenciones: JSON.stringify(this.retenciones),
                                                                            liquidaciones: JSON.stringify(this.liquidaciones),
                                                                        });
            },
            postForm: function(path, params, method){
                method = method || 'post';
                var form = document.createElement('form');
                form.setAttribute('method', method);
                form.setAttribute('action', path);
                var token = document.createElement('input');
                token.setAttribute('type', 'hidden');
                token.setAttribute('name', '_token');
                token.setAttribute('value', document.head.querySelector("[name=csrf-token]").content);
                form.appendChild(token);

                for (var key in params) {
                    if (params.hasOwnProperty(key)) {
                        var hiddenField = document.createElement('input');
                        hiddenField.setAttribute('type', 'hidden');
                        hiddenField.setAttribute('name', key);
                        hiddenField.setAttribute('value', params[key]);
                        form.appendChild(hiddenField);
                    }
                }
                document.body.appendChild(form); form.submit();
            },
            reiniciar(){
                //Object.assign(this.$data, this.$options.data());
                window.location.href="/admin/ingreso_facturas/sri/"+this.inputSubservicio+"/"+this.inputTipoPlan+"/"+this.inputUsuarioEmpresa;
            },
            guardarRegistrosAuto(){
                let respuestaValidacion = validaFormulario();
                if(!respuestaValidacion)
                {
                    let tablaFacturas = document.getElementById('tablaFacturas');
                    var jsonFacturas = [];
                    document.getElementById('mensajeGuardando').style.display = "block";

                    for (let row of tablaFacturas.rows)
                    {
                        var cont = 0;
                        var arrayCells = [];
                        for(let cell of row.cells)
                        {
                            switch (cont) {
                                case 0:
                                    arrayCells["key"] = cell.innerText;
                                    break;
                                case 1:
                                    arrayCells["fechaEmision"] = cell.innerText;
                                    break;
                                case 3:
                                    arrayCells["tipo"] = cell.innerText;
                                    break;
                                case 4:
                                    arrayCells["categoria"] = cell.firstChild.value;
                                    break;
                                case 5:
                                    arrayCells["tipoTransaccion"] = cell.firstChild.value;
                                    break;
                                case 8:
                                    arrayCells["tarifaDifCero"] = cell.innerText.replace('$','');
                                    break;
                                case 9:
                                    arrayCells["tarifaCero"] = cell.innerText.replace('$','');
                                    break;
                                case 10:
                                    arrayCells["iva"] = cell.innerText.replace('$','');
                                    break;
                                case 11:
                                    arrayCells["total"] = cell.innerText.replace('$','');
                                    break;
                            }
                            cont++;
                        }
                        jsonFacturas.push({key: arrayCells["key"],
                                    fechaEmision: arrayCells["fechaEmision"],
                                    tipo: arrayCells["tipo"],
                                    categoria: arrayCells["categoria"],
                                    tipoTransaccion: arrayCells["tipoTransaccion"],
                                    tarifaDifCero: arrayCells["tarifaDifCero"],
                                    tarifaCero: arrayCells["tarifaCero"],
                                    iva: arrayCells["iva"],
                                    total: arrayCells["total"],
                        });
                    }

                    /*this.postForm( '/admin/guardarRegistrosAuto', {
                                                                    facturas: JSON.stringify(this.facturas),
                                                                    notasCredito: JSON.stringify(this.notas_credito),
                                                                    notasDebito: JSON.stringify(this.notas_debito),
                                                                    retenciones: JSON.stringify(this.retenciones),
                                                                    liquidaciones: JSON.stringify(this.liquidaciones),
                                                                    });*/

                    //let respuestaValidacion = validaFormulario();

                    //if(respuestaValidacion){
                        //document.getElementsByClassName('msjGuardando')[0].style.display = "block";
                        //let set = this;
                        let url = '/admin/guardarRegistrosAuto';
                        const config = {
                            headers: {
                                'content-type': 'multipart/form-data'
                            }
                        };

                        let data = new FormData();
                        data.append('facturas', JSON.stringify(jsonFacturas));//JSON.stringify(this.facturas));
                        data.append('notasCredito', JSON.stringify(this.notas_credito));
                        data.append('notasDebito', JSON.stringify(this.notas_debito));
                        data.append('retenciones', JSON.stringify(this.retenciones));
                        data.append('liquidaciones', JSON.stringify(this.liquidaciones));
                        data.append('tipoPlan', this.inputTipoPlan);
                        data.append('subservicio', this.inputSubservicio);
                        data.append('usuarioEmpresa', this.inputUsuarioEmpresa);
                        console.log("*** GUARDAR ***");
                        console.log(JSON.stringify(jsonFacturas));

                        let datos ={
                            url : url,
                            config: config,
                            data: data
                        };

                        axios.post(datos.url, datos.data, datos.config)
                            .then(function(res) {
                                //this.buttonDisable = true;
                                //document.getElementsByClassName('msjGuardando')[0].style.display = "none";
                                //let link = "/admin/ingreso_facturas/ingreso_manual/"+this.subServicio+"/"+this.tipoPlan+"/";
                                //window.location = link;
                                document.getElementById('mensajeGuardando').style.display = "none";
                                document.getElementById('alertaGuardado').style.display = 'block';

                                setTimeout(function () {
                                    window.location.href = window.location.href;
                                }, 2000);
                                //window.location.href="/admin/ingreso_facturas/sri/"+this.inputSubservicio+"/"+this.inputTipoPlan+"/"+this.inputUsuarioEmpresa;
                            })
                            .catch(function(error) {
                                //if (error.response.status == 422) {
                                    //set.errors.record(error.response.datos.errors);
                                //}
                                //set.buttonDisable = false;
                            });
                //}
                }
            },

        },
        computed: {
            facturasOrderBy: function () {
                return _.orderBy(this.facturas, 'fechaEmision', 'asc');
            },
            notasCredOrderBy: function () {
                return _.orderBy(this.notas_credito, 'fechaEmision', 'asc');
            },
            notasDebOrderBy: function () {
                return _.orderBy(this.notas_debito, 'fechaEmision', 'asc');
            },
            retenOrderBy: function () {
                return _.orderBy(this.retenciones, 'fechaEmision', 'asc');
            },
            liquidacionesOrderBy: function () {
                return _.orderBy(this.liquidaciones, 'fechaEmision', 'asc');
            }
        }
    }
</script>

<style>
.page-item {
    cursor: pointer;
}
</style>
