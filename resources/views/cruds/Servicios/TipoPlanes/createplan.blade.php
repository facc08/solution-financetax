@extends('layouts.app')

@section('content')

    <h1 class="text-center font-weight-bold">Planes</h1>


    <div id="planes">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Plan</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Servicio</label>
                                        <model-list-select :list="servicios" v-model="service_id" option-value="id"
                                            option-text="nombre" placeholder="Seleccione un Servicio">
                                        </model-list-select>

                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputPassword4">Tipo Plan</label>
                                        <model-list-select :list="tipoplanes" v-model="tipoplan_id" option-value="id"
                                            option-text="nombre" placeholder="Seleccione un Tipo Plan">
                                        </model-list-select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputPassword4">Precio</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    $
                                                </div>
                                            </div>
                                            <input type="number" id="input" v-model="costo" class="form-control currency"
                                                placeholder="Precio">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputPassword4">Cantidad Meses</label>
                                        <input type="number" v-model="cantidad_meses" class="form-control" placeholder="Cantidad Meses">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputAddress">Descripción</label>
                                    <ckeditor v-model="descripcion" :config="config"></ckeditor>
                                    @error('descripcion')
                                        <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-12">
                                    <label class="text-dark" for="">Documento:</label>
                                    <input type="file" v-on:change="getArchivo">
                                    <p class="error-message text-danger font-weight-bold" v-if="errors.has('documento')">
                                        @{{ errors . get('documento') }}</p>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="/servicios/planes" class="btn btn-light btn-sm" role="button">Regresar</a>
                                <button class="btn btn-primary btn-sm" :disabled="buttonDisable"
                                    @click.prevent="validaciones('activo')">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection


@section('js')
<script src="//cdn.ckeditor.com/4.16.2/full/ckeditor.js"></script>
    <script type="text/javascript">
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


        let servicios = @json($servicios);
        let tipoplanes = @json($tipoplan);
        const planes = new Vue({
            el: "#planes",
            name: "Planes",
            data: {

                servicios: servicios,
                tipoplanes: tipoplanes,
                service_id: '',
                tipoplan_id: '',
                descripcion: '',
                documento: null,
                editMode: false,
                buttonDisable: false,
                plan_id: '',
                costo: '',
                cantidad_meses: '',
                errors: new Errors,
                config: {
                toolbar: [
                    ['Bold', 'Italic', 'Underline', 'Strike', 'Styles', 'TextColor', 'BGColor', 'UIColor' , 'JustifyLeft' , 'JustifyCenter' , 'JustifyRight' , 'JustifyBlock' , 'BidiLtr' , 'BidiRtl' , 'NumberedList' , 'BulletedList' , 'Outdent' , 'Indent' , 'Blockquote' , 'CreateDiv','Format','Font','FontSize']
                    ],
                     height: 300,
                 }

            },

            methods: {
                //almacenamiento de de documentos
                getArchivo(event) {
                    this.documento = event.target.files[0];
                },  //end almacenamiento de documentos

                //validacion de datos
                validaciones(estado){
                    if (this.service_id === '') {
                        iziToast.error({
                            title: 'SolutionFinanceTax',
                            message: 'No has seleccionado el Servicio',
                            position: 'topRight'
                         });
                    } else if (this.tipoplan_id === '') {
                        iziToast.error({
                            title: 'SolutionFinanceTax',
                            message: 'No has seleccionado el Tipo Plan',
                            position: 'topRight'
                          });
                    }else if (this.descripcion === '') {
                        iziToast.error({
                                title: 'SolutionFinanceTax',
                                message: 'Debe Agregar la Descripción',
                                position: 'topRight'
                    });
                    } else if (this.costo === '') {
                        iziToast.error({
                                title: 'SolutionFinanceTax',
                                message: 'Debe Agregar el Precio',
                                position: 'topRight'
                    });
                    }  else {
                    let datos = this.createData(estado);
                    return this.storePlan(datos);
                    console.log(datos);
                    }
                },// end validaciones

                //creacion de datos para almacenamento
                createData(estado){
                    let set = this;
                    let url ='/servicios/store-plan';
                    const config = {
                        headers: {
                            'content-type': 'multipart/form-data'
                        }
                    }
                    let data = new FormData();
                    data.append('service_id' , this.service_id);
                    data.append('tipoplan_id' , this.tipoplan_id);
                    if (this.documento !== null) {
                            data.append('documento', this.documento);
                    }
                    data.append('descripcion', this.descripcion);
                    data.append('costo', this.costo);
                    data.append('cantidad_meses', this.cantidad_meses);
                    data.append('estado', estado);
                    if (set.editMode) {
                        data.append('edit', 'si');
                    } else {
                        data.append('edit', 'no')
                    }
                    data.append('plan_id', set.plan_id);
                    let datos = {
                        url: url,
                        config: config,
                        data: data
                    };
                    return datos;
                }, //end createData


                //almacenamiento de la informacion
                storePlan(data){
                    let set = this;
                    axios.post(data.url, data.data, data.config)
                      .then(function(res){
                        console.log(res.data);
                          this.buttonDisable= true;
                          let link = '{{ route('servicios.planes')}}';
                          window.location = link;
                      })
                      .catch(function(error){
                        if (error.response.status == 422) {
                        set.errors.record(error.response.data.errors);
                        }
                        set.buttonDisable = false;
                      });


                }, //end storePlan

                editPlan(plans){
                    this.descripcion     = plans.descripcion;
                    this.service_id      = parseInt(plans.service_id);
                    this.tipoplan_id     = parseInt(plans.tipoplan_id);
                    this.cantidad_meses  = plans.cantidad_meses;
                    this.costo           = plans.costo;
                    this.plan_id         = plans.id;
                    this.editMode        = true;

                    console.log(parseInt(this.service_id));
                    console.log(parseInt(this.tipoplan_id));
                    console.log(this.plan_id );
                }



            },

        });

        @if (Request::has('plans'))
                console.log(@json($plans))
                planes.editPlan(@json($plans))
         @endif


    </script>
    

@endsection
