@extends('layouts.app')

@section('content')

    <h1 class="text-center font-weight-bold">Servicio</h1>

    <div id="ser">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Servicio</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label >Tipo Servicio</label>
                                        <model-list-select :list="tiposervicios" v-model="tiposervicio_id"   option-value="id"  
                                        option-text="nombre"  placeholder="Seleccione un Tipo Servicio">
                                        </model-list-select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputPassword4">Servicio</label>
                                        <input type="text" class="form-control" id="input" v-model="nombre" placeholder="Servicio">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputAddress">Descripción</label>
                                    <ckeditor v-model="descripcion" :config="config"></ckeditor>
                                 
                                    @error('descripcion')
                                        <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="text-dark" for="">Imagen:</label>
                                    <input type="file" v-on:change="getArchivo">
                                    <p class="error-message text-danger font-weight-bold" v-if="errors.has('documento')">
                                        @{{ errors . get('documento') }}</p>
                                </div>

                            </div>
                            <div class="card-footer">
                                <button class="btn btn-primary btn-sm" :disabled="buttonDisable"
                                @click.prevent="validaciones('activo')">Guardar Servicio</button>
                               
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

        let tiposervicios = @json($tiposervicios);

        const ser = new Vue({
            el: "#ser",
            name:"Servicios",
            data:{
                tiposervicios: tiposervicios,
                tiposervicio_id : '',
                nombre:'',
                descripcion:'',
                errors: new Errors,
                documento :null,
                editMode: false,
                buttonDisable: false,
                service_id:'',
                config: {
                toolbar: [
                    ['Bold', 'Italic', 'Underline', 'Strike', 'Styles', 'TextColor', 'BGColor', 'UIColor' , 'JustifyLeft' , 'JustifyCenter' , 'JustifyRight' , 'JustifyBlock' , 'BidiLtr' , 'BidiRtl' , 'NumberedList' , 'BulletedList' , 'Outdent' , 'Indent' , 'Blockquote' , 'CreateDiv','Format','Font','FontSize']
                    ],
                     height: 300,
                 }
            },//en data

            methods: {
                getArchivo(event){
                    this.documento = event.target.files[0];
                }, //end carga de archivo

                validaciones(estado){
                    if (this.tiposervicio_id === '') {
                    iziToast.error({
                            title: 'SolutionFinanceTax',
                            message: 'No has seleccionado el Tipo Servicio',
                            position: 'topRight'
                     });
                    } else if (this.nombre === '') {
                    iziToast.error({
                            title: 'SolutionFinanceTax',
                            message: 'Debe Agregar el Nombre',
                            position: 'topRight'
                     });
                     }else if (this.descripcion === '') {
                        iziToast.error({
                                title: 'SolutionFinanceTax',
                                message: 'Debe Agregar la Descripción',
                                position: 'topRight'
                        });
                    } else {
                        let datos = this.createData(estado);
                        return this.storeService(datos);
                        console.log(datos);
                    }

                }, //end validaciones 

                createData(estado){
                    let set = this;
                    let url = '/servicios/store-servicio';
                    const config = {
                        headers: {
                            'content-type': 'multipart/form-data'
                        }
                    }
                    let data = new FormData();
                    data.append('tiposervicio_id', this.tiposervicio_id);
                    if (this.documento !== null) {
                        data.append('documento', this.documento);
                    }
                    data.append('nombre', this.nombre);
                    data.append('descripcion', this.descripcion);
                    data.append('estado', estado);
                    if (set.editMode) {
                        data.append('edit','si')
                    }else{
                        data.append('edit','no')
                    }
                    data.append('service_id', set.service_id);
                    let datos ={
                        url : url,
                        config: config,
                        data: data
                    };
                    return datos;
                }, 

                editSer(services){
                    this.nombre = services.nombre;
                    this.descripcion = services.descripcion;
                    this.tiposervicio_id = parseInt(services.tiposervicio_id);
                    this.editMode = true;
                    this.service_id    = services.id;
                },

                storeService(data) {
                    let set = this;
                    axios.post(data.url, data.data, data.config)
                        .then(function(res) {
                            console.log(res.data);
                            this.buttonDisable = true;
                             let link = '{{ route('servicios.servicio') }}';
                             window.location = link;
                            
                        })
                        .catch(function(error) {
                            if (error.response.status == 422) {
                                set.errors.record(error.response.data.errors);
                            }
                            set.buttonDisable = false;
                        });

                } //end store




            }, //end methods
        });

        @if(Request::has('services'))
                 console.log(@json($services))
                 ser.editSer(@json($services))
        @endif

</script>

@endsection