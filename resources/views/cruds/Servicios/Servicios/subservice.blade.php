@extends('layouts.app')

@section('content')

    <h1 class="text-center font-weight-bold">Sub Servicio</h1>

<div id="subservicio">
    <section class="section">
        <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Sub Servicio</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label >Tipo Servicio</label>
                                        <model-list-select :list="tipoServicios" v-model="tipoService_id" option-value="id"
                                            option-text="nombre"  placeholder="Seleccione un Servicio"
                                            @input="cambiarTipoServicio()">
                                        </model-list-select>

                                    </div>
                                    <div class="form-group col-md-4">
                                        <label >Servicio</label>
                                        <model-list-select :list="servicios" v-model="service_id"   option-value="id"
                                        option-text="nombre"  placeholder="Seleccione un Servicio">
                                        </model-list-select>

                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="inputPassword4">Subservicio</label>
                                        <input type="text" class="form-control" id="input" v-model="nombre" placeholder="Subservicio">
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
                                <button class="btn btn-primary btn-sm" :disabled="buttonDisable"
                                @click.prevent="validaciones('activo')">Guardar Subservicio</button>
                               
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


  let listaServicios = @json($servicios);

  let tipoServicios = @json($tipoServicios);

  const subservicio = new Vue({
     el: "#subservicio",
     name: "Subservicios",
     data:{
         //servicios: servicios,
         servicios: [],
         tipoServicios: tipoServicios,
         service_id:'',
         tipoService_id:'',
         nombre:'',
         descripcion:'',
         errors: new Errors,
         documento :null,
         editMode: false,
         buttonDisable: false,
         subservice_id:'',
         config: {
                toolbar: [
                    ['Bold', 'Italic', 'Underline', 'Strike', 'Styles', 'TextColor', 'BGColor', 'UIColor' , 'JustifyLeft' , 'JustifyCenter' , 'JustifyRight' , 'JustifyBlock' , 'BidiLtr' , 'BidiRtl' , 'NumberedList' , 'BulletedList' , 'Outdent' , 'Indent' , 'Blockquote' , 'CreateDiv','Format','Font','FontSize']
                    ],
        height: 300,
        }
     },

     methods: {
        cambiarTipoServicio(){
            let selectServicios = [];
            let tipoServicio = this.tipoService_id;

            listaServicios.forEach(function (value) {
                if(value.tipoServicio == tipoServicio){
                    selectServicios.push({nombre: value.nombre, id: value.id});
                }
            });

            this.servicios = selectServicios;
		},
         getArchivo(event){
            this.documento = event.target.files[0];
         },

         validaciones(estado){
                if (this.servicio_id === '') {
                    iziToast.error({
                            title: 'SolutionFinanceTax',
                            message: 'No has seleccionado el Servicio',
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
                    return this.storeSubservice(datos);
                    console.log(datos);
                }
         },


         createData(estado){
            let set = this;
            let url = '/servicios/store-subservicios';
            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                 }
            }
            let data = new FormData();
            data.append('service_id', this.service_id);
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
            data.append('subservice_id', set.subservice_id);
            let datos ={
                url : url,
                config: config,
                data: data
            };
            return datos;
         },

        editSubservice(subservices){
            this.nombre = subservices.nombre;
            this.descripcion = subservices.descripcion;
            this.tipoService_id = Number(subservices.tiposervicio_id);

            let selectServicios = [];
            let tipoServicio = subservices.tiposervicio_id;

            listaServicios.forEach(function (value) {
                if(value.tipoServicio == tipoServicio){
                    selectServicios.push({nombre: value.nombre, id: value.id});
                }
            });

            this.servicios = selectServicios;
            this.service_id = Number(subservices.service_id);

            this.editMode = true;
            this.subservice_id = Number(subservices.id);
        },
        storeSubservice(data) {
            let set = this;
            axios.post(data.url, data.data, data.config)
                .then(function(res) {
                    console.log(res.data);
                    this.buttonDisable = true;
                    let link = '{{ route('servicios.subservicio.index') }}';
                     window.location = link;
                    
                })
                .catch(function(error) {
                    if (error.response.status == 422) {
                        set.errors.record(error.response.data.errors);
                    }
                    set.buttonDisable = false;
                });

        }

       



     },      
  });
    @if(Request::has('subservices'))
        console.log(@json($subservices))
        subservicio.editSubservice(@json($subservices))
    @endif
</script>

@endsection
