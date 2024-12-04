<template>
    <div>
        <div class="row mb-2 justify-content-center">
            <div class="col-10">
                <highcharts :options="chartOptions"></highcharts>
            </div>
        </div>
        <div class="row mb-4 justify-content-center">
            <div class="col-10">
                <ul class="list-group">
                    <li class="list-group-item">
                        <i class="fa fa-circle" aria-hidden="true" style="color:#28a745;"></i>
                        INGRESOS
                        <span class="float-right">$ {{ ingresos }}</span>
                    </li>
                    <li class="list-group-item">
                        <i class="fa fa-circle" aria-hidden="true" style="color:#dc3545;"></i>
                        GASTOS
                        <span class="float-right">$ {{ gastos }}</span>
                    </li>
                    <li class="list-group-item">
                        <i class="fa fa-circle" aria-hidden="true" style="color:#17a2b8;"></i>
                        IMPUESTOS
                        <span class="float-right">$ {{ impuestos }}</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-md-4">
                <button class="btn btn-primary btn-block btn-lg"><i class="fa fa-calculator" aria-hidden="true"></i> DECLARAR IMPUESTOS</button>
            </div>
        </div>
    </div>
</template>
<script>
import moment from "moment";
import {Chart} from 'highcharts-vue'

export default {
    data() {
        return {
            chartOptions: {
                series: [{
                    color: '#21618c',
                    data: [
                        {
                            name: 'Ingresos',
                            color: '#28a745',
                            y: 750.25
                        },
                        {
                            name: 'Gastos',
                            color: '#dc3545',
                            y: 485.50
                        },
                        {
                            name: 'Impuestos',
                            color: '#17a2b8',
                            y: 68.20
                        }
                    ],
                }],
                chart: {
                    type: 'column'
                },
                title: {
                    text: ''
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
                    categories: ['Ingresos','Gastos','Impuestos'],
                    //categories: [],
                },
                tooltip: {
                    formatter: function () {
                    return parseFloat(this.y).toFixed(2);
                    }
                },
            },
            ingresos: 750.25,
            gastos: 485.50,
            impuestos: 68.20,
        }
    },
    components: {
        highcharts: Chart
    },
}
</script>
