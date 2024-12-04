<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-12 text-center">
                                <button class="btn btn-primary btn-sm">Guardar</button>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="periodo" class="col-sm-2 col-form-label">Día</label>
                            <div class="col-sm-10">
                                <input v-model="periodo" type="date" class="form-control form-control-sm" id="periodo">
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="cuenta" class="col-sm-2 col-form-label">Cuenta</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control form-control-sm" id="cuenta">
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="categoria" class="col-sm-2 col-form-label">Categoría</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control form-control-sm" id="categoria">
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="valor" class="col-sm-2 col-form-label">Valor</label>
                            <div class="col-sm-10">
                                <money v-model="valor" class="form-control form-control-sm text-right"></money>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="detalle" class="col-sm-2 col-form-label">Detalle</label>
                            <div class="col-sm-10">
                                <input v-model="detalle" type="text" class="form-control form-control-sm" id="detalle">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row mb-2">
                            <label for="nota" class="col-sm-2 col-form-label">Nota</label>
                            <div class="col-sm-10 text-right">
                                <a href="#" @click="abrirInputFile">
                                    <i class="fa fa-camera fa-2x" aria-hidden="true"></i>
                                </a>
                                <input type="file" @change="obtenerImagen" class="form-control form-control-sm d-none" id="inputFile" accept="image/*">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-12 text-center">
                                <figure v-if="imgFactura != ''">
                                    <img width="220" height="240" alt="Imagen" :src="imagen" class="img img-thumbnail">
                                </figure>
                                <span v-show="procesando">Procesando...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import moment from "moment";
import {Money} from 'v-money'
import Tesseract from 'tesseract.js';

export default {
    data() {
        return {
            procesando: false,
            valor: 0,
            imgFactura: '',
            imagenMiniatura: '',
            periodo: moment().format('YYYY-MM-DD'),
            detalle: '',
        }
    },
    methods: {
        abrirInputFile(){
            $('#inputFile').click();
        },
        async obtenerImagen(e){
            var file = e.target.files[0];

            this.procesando = true;
            if(this.valor == 0){
                await Tesseract.recognize(file,'spa')
                    .progress(function(data){
                        console.log(data.status)
                    })
                    .then(function(data){
                        console.log(data)
                    });

            }

            this.procesando = false;
            this.imgFactura = file;
            this.cargarImagen(file);



        },
        cargarImagen(file){
            let reader = new FileReader();
            reader.onload = (e) => {
                this.imagenMiniatura = e.target.result;
            };
            reader.readAsDataURL(file);
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

</style>
