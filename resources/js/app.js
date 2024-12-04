

 require('./bootstrap');

// import * as FilePond from 'filepond';



window.Vue = require('vue');

import Vue from 'vue';

import VueIziToast from "vue-izitoast";
import "izitoast/dist/css/iziToast.css";
const defaultOptionsObject = {
    position: 'topRight',
}
Vue.use(VueIziToast,defaultOptionsObject);

require('bootstrap-daterangepicker');
import datatable from 'datatables.net-bs4';
import datatableres from 'datatables.net-responsive';
import datatableresbs4 from 'datatables.net-responsive-bs4';
require('datatables.net-buttons/js/dataTables.buttons')
require('datatables.net-buttons/js/buttons.html5')
require('datatables.net-datetime')
import print from 'datatables.net-buttons/js/buttons.print'

import VuePaginate from 'vue-paginate'
Vue.use(VuePaginate)

Vue.prototype.$tablaGlobal = function(nombre_tabla){
    this.$nextTick(()=>{
        $(nombre_tabla).DataTable().destroy();
        $(nombre_tabla).DataTable({
            "deferRender": true,
            //"autoWidth": true,
            "search": {
                "regex": true,
                "caseInsensitive": false,
            },
            "retrieve": true,
            "destroy": true,
            "bDeferRender": true,
            "sPaginationType": "full_numbers",
            "language":{
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla =(",
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
    });
}
import CKEditor from 'ckeditor4-vue';
Vue.use( CKEditor );
import 'vue-search-select/dist/VueSearchSelect.css';
import { ModelListSelect } from 'vue-search-select'
Vue.component('ModelListSelect', ModelListSelect);

Vue.component('comprobantesri-component', require('./components/ComprobantesSRIComponent.vue').default);
Vue.component('ingreso-manual-component', require('./components/IngresoManualComponent.vue').default);
Vue.component('grafico-contabilidad-component', require('./components/GraficoContabilidadComponent.vue').default);

Vue.component('gasto-factura-component', require('./components/GastoFacturaComponent.vue').default);
Vue.component('ingreso-factura-component', require('./components/IngresoFacturaComponent.vue').default);


/*     //Filepond
    const inputElement = document.querySelector('input[type="filepond"]');
    const pond = FilePond.create(inputElement);

    FilePond.setOptions({
        server: 'dashboard/user/upload'
    }) */


const app = new Vue({
     el: '#app',
});
